<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Services\PageService;

class PageController extends Controller
{
    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function getPageInfo(Request $request, $pageId)
    {
        try {
            // Retrieve page information using the PageService
            $pageInfo = $this->pageService->getPageInfo($pageId);

            // Check if page information is retrieved successfully
            if (!isset($pageInfo)) {
                return response()->json(['error' => 'Failed to retrieve page information'], 500);
            }

            //location
            $location =  $pageInfo['location']['city'] .','. $pageInfo['location']['country'] .','. $pageInfo['location']['street'] .','. $pageInfo['location']['zip'];
            // Process and potentially store the retrieved page information
            $page = Page::updateOrCreate(
                ['page_id' => $pageInfo['id']], // Unique identifier for the page
                [
                    'page_access_token' => $pageInfo['access_token'] ?? null, // Handle potential null value
                    'Categorie' => $pageInfo['category'] ?? null, // Handle potential null value
                    'NomPage' => $pageInfo['username'] ?? null, // Handle potential null value
                    'link' => $pageInfo['link'] ?? null, // Handle potential null value
                    'Location' => $location
                ]
            );

            // Return the processed page information in JSON format (consider what to return here)
            return response()->json($pageInfo); // Or $page->toArray() if returning the created/updated Page model
        } catch (\Exception $e) {
            // If an error occurs during the process, return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
