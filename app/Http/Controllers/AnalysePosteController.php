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
    public function showDatails($postId)
    {
        // Fetch post details from the database
        $post = Post::findOrFail($postId);

        // Fetch analytical data for the post
        $analysePoste = AnalysePoste::where('post_id', $postId)->get();

        // Initialize variables to store reaction totals
        $reactionTotals = [
            'like' => 0,
            'love' => 0,
            'wow' => 0,
            'haha' => 0,
            'sorry' => 0,
            'anger' => 0,
            'totalReactions' => 0, // Total count of reactions
        ];

        // Initialize other variables
        $impressions = $clicks = $negativeFeedback = $engagedFans = $numbreofviews = null;

        // Determine the post type
        $type = $post->type;

        // Calculate reaction totals
        foreach ($analysePoste as $analyseData) { // Change the variable name here
            switch ($analyseData->name) {
                case 'post_reactions_like_total':
                    $reactionTotals['like'] += $analyseData->value;
                    break;
                case 'post_reactions_love_total':
                    $reactionTotals['love'] += $analyseData->value;
                    break;
                case 'post_reactions_wow_total':
                    $reactionTotals['wow'] += $analyseData->value;
                    break;
                case 'post_reactions_haha_total':
                    $reactionTotals['haha'] += $analyseData->value;
                    break;
                case 'post_reactions_sorry_total':
                    $reactionTotals['sorry'] += $analyseData->value;
                    break;
                case 'post_reactions_anger_total':
                    $reactionTotals['anger'] += $analyseData->value;
                    break;
                case 'post_impressions':
                    $impressions = $analyseData->value;
                    break;
                case 'post_clicks':
                    $clicks = $analyseData->value;
                    break;
                case 'post_negative_feedback':
                    $negativeFeedback = $analyseData->value;
                    break;
                case 'post_engaged_fan':
                    $engagedFans = $analyseData->value;
                    break;
                case 'post_video_views':
                    $numbreofviews = $analyseData->value;
                    break;
            }

            // Calculate total count of reactions
            if (strpos($analyseData->name, 'post_reactions_') === 0) {
                $reactionTotals['totalReactions'] += $analyseData->value;
            }
        }

        // Pass the reaction totals, type, and other required data to the view
        return view('analyseposts', compact('post', 'reactionTotals', 'impressions', 'clicks', 'negativeFeedback', 'engagedFans', 'numbreofviews', 'type'));
    }

}
