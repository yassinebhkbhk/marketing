<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class AnalyseCommentsService
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

    public function analyseComment($commentId)
    {
        $fields = "like_count,user_likes,message_tags,comment_count,from";
        try {
            $url = "https://graph.facebook.com/v19.0/$commentId?fields=$fields&access_token=$this->pageAccessToken";
            $response = $this->guzzleClient->get($url);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody()->getContents(), true);
            } else {
                throw new \Exception("Échec de la récupération du commentaire: Code d'état " . $response->getStatusCode());
            }
        } catch (ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            $message = isset($error['error']['message']) ? "Erreur de l'API Facebook: " . $error['error']['message'] : "Erreur lors de la récupération du commentaire: " . $e->getMessage();
            throw new \Exception($message);
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération du commentaire: " . $e->getMessage());
        }
    }

    public function validateAccessToken()
    {
        $accessToken = $this->pageAccessToken;
        try {
            $url = "https://graph.facebook.com/debug_token?input_token=" . $accessToken . "&access_token=" . $accessToken;
            $response = $this->guzzleClient->get($url);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);
                return $data['data']['is_valid'];
            } else {
                throw new \Exception("Failed to validate access token: Status code " . $response->getStatusCode());
            }
        } catch (ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            $message = isset($error['error']['message']) ? "Facebook API error: " . $error['error']['message'] : "Error validating access token: " . $e->getMessage();
            throw new \Exception($message);
        } catch (\Exception $e) {
            throw new \Exception("Error validating access token: " . $e->getMessage());
        }
    }
}
