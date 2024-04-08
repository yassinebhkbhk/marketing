<?php

namespace App\Services;

use App\Models\MediaSocial;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class AnalysePagesService
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

    public function getPageInsights($page_id)
    {
        $accessToken = $this->pageAccessToken;
        $metric = "page_impressions,page_posts_impressions,page_impressions_paid,page_impressions_organic_v2,page_impressions_viral,page_negative_feedback,page_impressions_by_city_unique,post_engaged_fan,page_fans,page_fan_removes_unique,page_views_total,page_fan_adds_unique,";
        $period = "day";
        try {
            $url = "https://graph.facebook.com/v19.0/$page_id/insights?metric=$metric&period=$period&access_token=$accessToken";
            $response = $this->guzzleClient->get($url);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody()->getContents(), true);
            } else {
                throw new \Exception("Failed to retrieve insights: Status code " . $response->getStatusCode());
            }
        } catch (ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            $message = isset($error['error']['message']) ? "Facebook API error: " . $error['error']['message'] : "Error fetching Facebook insights: " . $e->getMessage();
            throw new \Exception($message);
        } catch (\Exception $e) {
            throw new \Exception("Error fetching Facebook insights: " . $e->getMessage());
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
    public function getdata($page_id,$since)
    {
        $accessToken = $this->pageAccessToken;
        $metric = "page_impressions";
        $period = "day";
        $since = "2024-03-01";
        $until = "2024-03-30";
        try {
            $url = "https://graph.facebook.com/v19.0/me/insights/$metric/$period?since=$since&until=$until&access_token=$accessToken";
            $response = $this->guzzleClient->get($url);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody()->getContents(), true);
            } else {
                throw new \Exception("Failed to retrieve insights: Status code " . $response->getStatusCode());
            }
        } catch (ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            $message = isset($error['error']['message']) ? "Facebook API error: " . $error['error']['message'] : "Error fetching Facebook insights: " . $e->getMessage();
            throw new \Exception($message);
        } catch (\Exception $e) {
            throw new \Exception("Error fetching Facebook insights: " . $e->getMessage());
        }
    }

}
