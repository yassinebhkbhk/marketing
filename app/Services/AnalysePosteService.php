<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class AnalysePosteService
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
        // Retrieve page access token securely (e.g., injected dependency or environment variable)
        $this->pageAccessToken = getenv('FACEBOOK_PAGE_ACCESS_TOKEN');
    }

    public function getPostAnalytics($postId)
{
    $accessToken = $this->pageAccessToken;
    $metric = "post_impressions,post_clicks,post_reactions_like_total,post_reactions_love_total,post_reactions_wow_total,post_reactions_haha_total,post_reactions_sorry_total,post_reactions_anger_total,post_negative_feedback,post_engaged_fan";
    $period = "lifetime";
    try {
        $url = "https://graph.facebook.com/v19.0/$postId/insights?metric=$metric&period=$period&access_token=$accessToken";
        $response = $this->guzzleClient->get($url);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody()->getContents(), true);
        } else {
            throw new \Exception("Failed to retrieve post analytics: Status code " . $response->getStatusCode());
        }
    } catch (ClientException $e) {
        $error = json_decode($e->getResponse()->getBody()->getContents(), true);
        $message = isset($error['error']['message']) ? "Facebook API error: " . $error['error']['message'] : "Error fetching post analytics: " . $e->getMessage();
        throw new \Exception($message);
    } catch (\Exception $e) {
        throw new \Exception("Error fetching post analytics: " . $e->getMessage());
    }
}


    public function getPostComments($postId)
    {
        $accessToken = $this->pageAccessToken;
        try {
            $url = "https://graph.facebook.com/v19.0/{$postId}/comments?access_token=$accessToken";
            $response = $this->guzzleClient->get($url);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody()->getContents(), true);
            } else {
                throw new \Exception("Failed to retrieve post comments: Status code " . $response->getStatusCode());
            }
        } catch (ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            $message = isset($error['error']['message']) ? "Facebook API error: " . $error['error']['message'] : "Error fetching post comments: " . $e->getMessage();
            throw new \Exception($message);
        } catch (\Exception $e) {
            throw new \Exception("Error fetching post comments: " . $e->getMessage());
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
