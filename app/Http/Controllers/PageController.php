<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Services\PageService;

class PageController extends Controller
{
    protected $pageService;

    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $pages = Page::where('user_id', $userId)->paginate(6);
        return view('pages', compact('pages'));
    }

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
            $location = $pageInfo['location']['city'] . ',' . $pageInfo['location']['country'] . ',' . $pageInfo['location']['street'] . ',' . $pageInfo['location']['zip'];
            // Process and potentially store the retrieved page information
            $page = Page::updateOrCreate(
                ['page_id' => $pageInfo['id']], // Unique identifier for the page
                [
                    'page_access_token' => $pageInfo['access_token'] ?? null, // Handle potential null value
                    'categorie' => $pageInfo['category'] ?? null, // Handle potential null value
                    'name_page' => $pageInfo['username'] ?? null, // Handle potential null value
                    'link' => $pageInfo['link'] ?? null, // Handle potential null value
                    'Location' => $location,
                    'picture_url' => $pageInfo['picture']['data']['url'] ?? null,
                    'cover_picture_url' => $pageInfo['cover']['source'] ?? null,
                    'about' => $pageInfo['about'] ?? null,
                    'rating_count' => $pageInfo['rating_count'] ?? null,
                    'fan_count' => $pageInfo['fan_count'] ?? null,
                    'email' => $pageInfo['emails'] ?? null,
                ]
            );
            // Return the processed page information in JSON format (consider what to return here)
            return response()->json($pageInfo); // Or $page->toArray() if returning the created/updated Page model
        } catch (\Exception $e) {
            // If an error occurs during the process, return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function pageCart($page_id)
    {
        $page = Page::findOrFail($page_id); // Assuming 'Page' is the model representing your page
        $fanCount = $page->fan_count;
        $ratingCount = $page->rating_count;

        return view('pagedetails', compact('fanCount', 'ratingCount'));
    }
}
