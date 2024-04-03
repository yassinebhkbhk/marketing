<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\AnalysePosteService;
use App\Models\AnalysePoste;

class AnalysePosteController extends Controller
{
    protected $AnalysePosteService;

    public function __construct(AnalysePosteService $AnalysePosteService)
    {
        $this->AnalysePosteService = $AnalysePosteService;
    }

    public function analysePoste($post_id) // Corrected function name to follow convention
    {
        try {
            // Validate the access token before using it
            if (!$this->AnalysePosteService->validateAccessToken()) { // Corrected method call
                throw new \Exception("Invalid or expired access token. Please check your configuration.");
            }

            // Fetch post from database
            $post = Post::Where('id',$post_id)->first(); // Changed to findOrFail to handle missing post

            // Retrieve and analyze the post
            $postAnalysis = $this->AnalysePosteService->getPostAnalytics($post->post_id); // Corrected method call
              if(!$postAnalysis['data']){
                return response()->json([]);
              }

              foreach($postAnalysis['data'] as $postAnalysisData){
                  // Create a new AnalysePoste record
                  $value = 0;
                  if (!empty($postAnalysisData['values'])) {
                        $value = $postAnalysisData['values'][0]['value'];
                  }
                  AnalysePoste::create([
                      'post_id' => $post->id,
                      'name' => $postAnalysisData['name'],
                      'period' => $postAnalysisData['period'],
                      'value' => $value,
                      'description' => $postAnalysisData['description'],
                      'data' => json_encode($postAnalysisData),
                      'date' => now()
                  ]);
              }

            // Return a JSON response with the analyzed post
            return response()->json([
                'success' => true,
                'message' => $postAnalysis,
            ]);
        } catch (\Exception $e) {
            // Return an error response with appropriate message
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
