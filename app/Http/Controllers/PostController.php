<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function getPostInfo(Request $request)
    {
        try {
            $userId = 1;
            $user = User::with(['pages'])->find($userId);
            $pages = $user->pages;
            //check if array has values
            if (!$pages || count($pages) == 0) {
                return response()->json([
                    'message' => "No pages found"
                ]);
            }
            $pageId = $pages[0]->id;
            $postInfo = $this->postService->getPostInfo();

            // Ensure $postInfo contains the 'data' key and it's an array
            if (isset($postInfo['data']) && is_array($postInfo['data'])) {
                // Loop over each post in the data array
                foreach ($postInfo['data'] as $post) {
                    // Validate if the post info exists and has an id
                    if (isset($post['id'])) {
                        $postId = substr($post['id'], 0, 255);
                        // Create or update a post record in the database note the post_id is unique
                        Post::updateOrCreate(
                            ['post_id' => $postId],
                            [
                                'post_id' => $post['id'],
                                'page_id' => $pageId,
                                'is_expired' => $post['is_expired'],
                                'parent_id' => isset($post['parent_id']) ? $post['parent_id'] : null, // Handle optional fields
                                'is_popular' => $post['is_popular'],
                                'message' => isset($post['message']) ? $post['message'] : null,
                                'type' => $post['status_type'],
                                'picture_url' => $post['picture'] ?? null,
                                'permalink_url' => $post['permalink_url'] ?? null,
                                'timeline_visibility' => $post['timeline_visibility'],
                                'promotion_status' => $post['promotion_status'],
                                'is_hidden' => $post['is_hidden'],
                                'is_published' => $post['is_published'],
                                'updated_time' => $post['updated_time'],
                                'created_time' => $post['created_time'],
                                'from_name' => $post['from']['name'], // Assuming you want to store this
                                'from_id' => $post['from']['id'], // Assuming you want to store this
                            ]
                        );
                    }
                }
            }

            // Return the post information in JSON format
            return response()->json($postInfo);
        } catch (\Exception $e) {
            // If an error occurs during the process, return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function posts($pageId)
    {
        $posts = Post::where('page_id', $pageId)->paginate(10);
        return view('posts', compact('posts'));
    }
    public function details($pageId)
    {
        $details = Post::where('page_id', $pageId)->paginate(10);
        return view('pagedetails', compact('details'));
    }
}
