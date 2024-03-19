<?php

namespace App\Http\Controllers;

use App\Models\AnalyseCommentaires;
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
            $comment = Commentaire::where('id', $commentId)->first();

            // Récupérer et analyser les commentaires
            $commentDetails = $this->analyseCommentsService->analyseComment($comment->comment_id);


            AnalyseCommentaires::create([
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
    
}
