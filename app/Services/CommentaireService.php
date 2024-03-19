<?php
namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class CommentaireService
{

    protected $guzzleClient;
    protected $pageAccessToken;

    public function __construct()
    {
        $this->guzzleClient = new GuzzleClient([
            'verify' => false, // Activer la vérification SSL pour la production
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        // Récupérer le jeton d'accès de page à partir de la variable d'environnement
        $this->pageAccessToken = getenv('FACEBOOK_PAGE_ACCESS_TOKEN');

        // Vérifier si le jeton d'accès de page est récupéré avec succès
        if (!$this->pageAccessToken) {
            throw new \Exception('Le jeton d\'accès de page Facebook n\'a pas été trouvé. Veuillez définir la variable d\'environnement FACEBOOK_PAGE_ACCESS_TOKEN.');
        }
    }
    public function getCommentsInfoByPost($postId)
    {
        $fields = "like_count,user_likes,message_tags,comment_count";
        try {
            $url = "https://graph.facebook.com/$postId/comments?access_token=$this->pageAccessToken";
            $response = $this->guzzleClient->get($url);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody()->getContents(), true);
            } else {
                throw new \Exception("Échec de la récupération les commentaires: Code d'état " . $response->getStatusCode());
            }
        } catch (ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            $message = isset($error['error']['message']) ? "Erreur de l'API Facebook: " . $error['error']['message'] : "Erreur lors de la récupération les commentaires: " . $e->getMessage();
            throw new \Exception($message);
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération les commentaires: " . $e->getMessage());
        }
    }

}

