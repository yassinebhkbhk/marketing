<?php

namespace App\Http\Controllers;

use App\Models\AnalysePage;
use App\Models\Page;
use App\Models\AnalysePages;
use Illuminate\Http\Request;
use App\Services\AnalysePagesService;



class AnalysePagesController extends Controller
{
    protected $AnalysePagesService;

    public function __construct(AnalysePagesService $AnalysePagesService)
    {
        $this->AnalysePagesService = $AnalysePagesService;
    }

    public function getPageInsights($page_id) // Corrected function name to follow convention
    {
        try {
            // Validate the access token before using it
            if (!$this->AnalysePagesService->validateAccessToken()) { // Corrected method call
                throw new \Exception("Invalid or expired access token. Please check your configuration.");
            }

            // Fetch post from database
            $page = Page::Where('id',$page_id)->first(); // Changed to findOrFail to handle missing post

            // Retrieve and analyze the post
            $pageAnalyse = $this->AnalysePagesService->getPageInsights($page->page_id); // Corrected method call
              if(!$pageAnalyse['data']){
                return response()->json([]);
              }

              foreach($pageAnalyse['data'] as $pageAnalyseData){
                  // Create a new AnalysePoste record
                  $value = 0;
                  if (!empty($pageAnalyseData['values'])) {
                        $value = $pageAnalyseData['values'][0]['value'];
                  }
                  AnalysePage::create([
                      'page_id' => $page->id,
                      'name' => $pageAnalyseData['name'],
                      'period' => $pageAnalyseData['period'],
                      'value' => $value,
                      'description' => $pageAnalyseData['description'],
                      'data' => json_encode($pageAnalyseData),
                      'date' => now()
                  ]);
              }

            // Return a JSON response with the analyzed post
            return response()->json([
                'success' => true,
                'message' => $pageAnalyse,
            ]);
        } catch (\Exception $e) {
            // Return an error response with appropriate message
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function insights($page_id)
    {
        $page = AnalysePage::findOrFail($page_id); // Assuming 'Page' is the model representing your page
        $fanCount = $page->fan_count;
        $ratingCount = $page->rating_count;
        $page_impressions= AnalysePage::query()->where("page_id",$page_id)->where("name","page_impressions" )->where("period","month");
        dd($page_impressions);
        return view('pagedetails', compact('fanCount', 'ratingCount','page_impressions'));
    }

    //
}
