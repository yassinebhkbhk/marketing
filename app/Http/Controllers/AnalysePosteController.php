<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AnalysePosteService;

class AnalysePosteController extends Controller
{
    protected $analysePosteService;

    public function __construct(AnalysePosteService $analysePosteService)
    {
        $this->analysePosteService = $analysePosteService;
    }

    public function getPostAnalytics(Request $request, $postId)
    {
        try {
            // Analyze the post using the AnalysePosteService
            $analytics = $this->analysePosteService->getPostAnalytics($postId);

            // Return the analytics as JSON response
            return response()->json($analytics);
        } catch (\Exception $e) {
            // If an error occurs during the process, return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPostComments($postId)
    {
        try {
            // Retrieve comments for the post using the AnalysePosteService
            $comments = $this->analysePosteService->getPostComments($postId);

            // Return the comments as JSON response
            return response()->json($comments);
        } catch (\Exception $e) {
            // If an error occurs during the process, return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}



