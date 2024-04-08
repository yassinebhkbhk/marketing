<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class PostService
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

    public function getPostInfo()
    {

        $url = "https://graph.facebook.com/v19.0/me/feed?fields=status_type,permalink_url,id,message,target,to,created_time,picture,attachments,from,is_expired,parent_id,is_popular,timeline_visibility,promotion_status,is_hidden,is_published,updated_time&access_token=" . $this->pageAccessToken;
        $response = $this->guzzleClient->get($url);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody()->getContents(), true);
        } else {
            return $response->getBody();
        }
    }
}
