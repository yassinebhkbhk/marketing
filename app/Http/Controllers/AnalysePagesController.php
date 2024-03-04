<?php

namespace App\Http\Controllers;

use App\Services\AnalysePagesService;
use Illuminate\Http\Request;



class AnalysePagesController extends Controller
{
    protected $AnalysePagesService;

    public function __construct(AnalysePagesService $AnalysePagesService)
    {
        $this->AnalysePagesService = $AnalysePagesService;
    }

    public function getPageInsights()
    {
        try {
            // Optional: Validate page ID or other input
            // $metric = $request->query('metric', 'page_impressions'); // Optional: Allow customization
            // $period = $request->query('period', 'day'); // Optional: Allow customization

            // Validate access token before using it
            if (!$this->AnalysePagesService->validateAccessToken()) {
                throw new \Exception("Invalid or expired access token. Please check your Facebook developer portal for access token generation and configuration.");
            }

            $data = $this->AnalysePagesService->getPageInsights();
            // create in database

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    //
}
