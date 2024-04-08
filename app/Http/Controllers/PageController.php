<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\AnalysePage;
use Illuminate\Http\Request;
use App\Services\PageService;
use App\Services\AnalysePagesService;

class PageController extends Controller
{
    protected $pageService;
    protected $analysePagesService;

    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $pages = Page::where('user_id', $userId)->paginate(6);
        return view('pages', compact('pages'));
    }
    public function __construct(PageService $pageService,AnalysePagesService $analysepageService)
    {
        $this->pageService = $pageService;
        $this->analysePagesService = $analysepageService;
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
    public function pageCart(Request $request,$page_id)
    {
        $page = Page::findOrFail($page_id); // Assuming 'Page' is the model representing your page
        $fanCount = $page->fan_count;
        $ratingCount = $page->rating_count;

        // Retrieve page impressions data for the month from the database or any other source
        $page_impressions_data = AnalysePage::where("page_id", $page_id)
                                            ->where("name", "page_impressions")
                                            ->where("period", "month")
                                            ->get(); // Or ->first() if you expect only one row

        // Calculate total page impressions for the month
        $totalPageImpressions = $page_impressions_data->isEmpty() ? 0 : $page_impressions_data->sum('value');
        // Count page posts
        $numberOfPagePosts = $this->countPagePosts($page_id);

        // Pass data to the view
        return view('pagedetails', compact('fanCount', 'ratingCount', 'totalPageImpressions', 'page_impressions_data', 'numberOfPagePosts'));
    }

    public function countPagePosts($page_id)
    {
        // Assuming you have a model named 'PagePost' representing page posts
        // You should replace 'PagePost' with your actual model name
        $numberOfPagePosts = Post::where('page_id', $page_id)->count();

        return $numberOfPagePosts;
    }

    public function getdata(Request $request, $page_id, $since, $until)
{
    try {
        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');

        $page = Page::where('id', $page_id)->first();
        // Retrieve page information using the PageService
        $pageInfo = $this->analysePagesService->getdata($page->page_id, $since, $until);

        // Check if page information is retrieved successfully
        if (!isset($pageInfo)) {
            return response()->json(['error' => 'Failed to retrieve page information'], 500);
        }

        // Return the view with necessary data
        return view('pagedetails', [
            'startDateInput' => $startDateInput,
            'endDateInput' => $endDateInput,
            'page_impressions_data' => $pageInfo // Assuming $pageInfo contains page impressions data
        ]);

    } catch (\Exception $e) {
        // If an error occurs during the process, return an error response
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
