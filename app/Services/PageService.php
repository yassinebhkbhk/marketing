<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class PageService
{
    protected $guzzleClient;
    protected $pageAccessToken;

    public function __construct()
    {
        $this->guzzleClient = new GuzzleClient([
            'verify' => false, // Enable SSL verification for production
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        // Retrieve page access token from .env file
        $this->pageAccessToken = env('FACEBOOK_PAGE_ACCESS_TOKEN');
    }

    public function getPageInfo(string $pageId)
    {
        try {
            $url = "https://graph.facebook.com/v19.0/{$pageId}?fields=access_token,fan_count,contact_address,current_location,start_info,emails,rating_count,id,about,bio,cover,category,differently_open_offerings,picture,engagement,username,location,link&access_token={$this->pageAccessToken}";
            $response = $this->guzzleClient->get($url);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody()->getContents(), true);

            } else {
                throw new \Exception("Failed to retrieve page info: Status code " . $response->getStatusCode());
            }
        } catch (ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            $message = isset($error['error']['message']) ? "Facebook API error: " . $error['error']['message'] : "Error fetching page info: " . $e->getMessage();
            throw new \Exception($message);
        } catch (\Exception $e) {
            throw new \Exception("Error fetching page info: " . $e->getMessage());
        }
    }
}
