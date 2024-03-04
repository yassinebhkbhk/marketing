<?php

namespace App\Services;

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

    public function getPageInsights()
    {
        $accessToken = $this->pageAccessToken;
        $metric = "page_engaged_users,page_total_actions,page_consumptions,page_posts_impressions_frequency_distribution,page_tab_views_login_top,page_cta_clicks_by_age_gender_logged_in_unique,page_cta_clicks_logged_in_by_country_unique,page_impressions_by_age_gender_unique, page_actions_post_reactions_like_total,page_actions_post_reactions_love_total,page_actions_post_reactions_like_total,page_actions_post_reactions_wow_total,page_actions_post_reactions_haha_total,page_actions_post_reactions_sorry_total,page_actions_post_reactions_anger_total,page_fan_removes_unique,page_fans_by_unlike_source_unique,page_fans,page_fans_city,page_fans_country,page_views_by_age_gender_logged_in_unique ";
        $period = "days_28";
        try {
            $url = "https://graph.facebook.com/v19.0/me/insights?metric=" . $metric . "&period=" . $period . "&access_token=" . $accessToken;
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
}
