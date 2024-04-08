<?php

namespace App\Http\Controllers;

use App\Models\AnalyseComment;
use App\Models\Comment;
use App\Models\Commentaire;
use App\Services\AnalyseCommentsService;
use Illuminate\Http\Request;

class AnalyseCommentsController extends Controller
{
    protected $analyseCommentsService;

    public function __construct(AnalyseCommentsService $analyseCommentsService)
    {
        $this->analyseCommentsService = $analyseCommentsService;
    }

    public function analyseComments($commentId)
    {
        try {
            // Valider le commentaire ID ou d'autres données d'entrée si nécessaire
            // $commentId = $request->query('comment_id');

            // Valider le jeton d'accès avant de l'utiliser
            if (!$this->analyseCommentsService->validateAccessToken()) {
                throw new \Exception("Jeton d'accès invalide ou expiré. Veuillez vérifier votre configuration.");
            }

            //get from database
            $comment = Comment::where('id', $commentId)->first();

            // Récupérer et analyser les commentaires
            $commentDetails = $this->analyseCommentsService->analyseComment($comment->comment_id);


            AnalyseComment::create([
                'comment_id' => $comment->id,
                 'like_count' => $commentDetails['like_count'],
                 'user_likes' => $commentDetails['user_likes'],
                 'comment_count' => $commentDetails['comment_count'],
                 'data' => json_encode($commentDetails),
                 'date' => now()
                 ]);

            // Exemple: retourner un message JSON avec les commentaires analysés
            return response()->json([
                'success' => true,
                'message' => $commentDetails,
            ]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur avec un message approprié
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function comment($commentId)
    {
        $commentDetails = AnalyseComment::where('comment_id', $commentId)->paginate(10);
        return view('postcomment', compact('commentDetails'));
    }
    public function getLikeCountData()
    {
        // Retrieve like count data from the database
        $likeCountData = AnalyseComment::select('date', 'like_count')
                            ->orderBy('date')
                            ->get();

        // Format data for Chart.js
        $likeCountChartData = $likeCountData->map(function ($item) {
            return [
                'date' => $item->date->format('Y-m-d'), // Assuming date field is in 'Y-m-d' format
                'value' => $item->like_count
            ];
        });

        return $likeCountChartData;
    }

    public function getCommentCountData()
    {
        // Retrieve comment count data from the database
        $commentCountData = AnalyseComment::select('date', 'comment_count')
                                ->orderBy('date')
                                ->get();

        // Format data for Chart.js
        $commentCountChartData = $commentCountData->map(function ($item) {
            return [
                'date' => $item->date->format('Y-m-d'), // Assuming date field is in 'Y-m-d' format
                'value' => $item->comment_count
            ];
        });

        return $commentCountChartData;
    }
}
