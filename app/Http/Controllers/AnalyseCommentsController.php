<?php

namespace App\Http\Controllers;

use App\Models\AnalyseCommentaires;
use App\Services\AnalyseCommentsService;
use Illuminate\Http\Request;

class AnalyseCommentsController extends Controller
{
    protected $analyseCommentsService;

    public function __construct(AnalyseCommentsService $analyseCommentsService)
    {
        $this->analyseCommentsService = $analyseCommentsService;
    }

    public function analyseComments( $commentId)
    {
        try {
            // Valider le commentaire ID ou d'autres données d'entrée si nécessaire
            // $commentId = $request->query('comment_id');

            // Valider le jeton d'accès avant de l'utiliser
            if (!$this->analyseCommentsService->validateAccessToken()) {
                throw new \Exception("Jeton d'accès invalide ou expiré. Veuillez vérifier votre configuration.");
            }

            // Récupérer et analyser les commentaires
            $commentDetails = $this->analyseCommentsService->analyseComment($commentId);


            AnalyseCommentaires::create([
                 'like_count' => $commentDetails['like_count'],
                 'user_likes' => $commentDetails['user_likes'],
                 'comment_count' => $commentDetails['comment_count'],
               'comment_id' => $commentDetails['id']
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

private function collectDataFromAPI($commentId, $accessToken)
{
    // Define the API URL and query parameters (replace with your actual values)
    $url = 'https://api.example.com/comments?comment_id=' . $commentId;

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Accept: application/json',
    ];

    // Send the request and retrieve the response
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        throw new \Exception('Error during API request: ' . curl_error($curl));
    }

    curl_close($curl);

    $responseData = json_decode($response, true);

    // Check if the response is successful and collect the desired data
    if ($responseData['success']) {
        $commentData = [
            'like_count' => $responseData['message']['like_count'],
            'user_likes' => $responseData['message']['user_likes'],
            'comment_count' => $responseData['message']['comment_count'],
            'id' => $responseData['message']['id'],
        ];


        return $commentData;
    } else {
        throw new \Exception('API response indicates an error: ' . $responseData['message']);
    }
}


}
