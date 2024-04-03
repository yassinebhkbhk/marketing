<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Services\CommentService;


class CommentaireController extends Controller
{
    protected $CommentService;

    public function __construct(CommentService $CommentService)
    {
        $this->CommentService = $CommentService;
    }

    public function getCommentsInfo(Request $request)
    {
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
        $posts = Post::where('page_id', $pageId)->get();
        foreach ($posts as $post) {
            try {
                $postComments = $this->CommentService->getCommentsInfoByPost($post->post_id);
                // Ensure $postComments contains the 'data' key and it's an array
                if (isset($postComments['data']) && is_array($postComments['data'])) {
                    // Loop over each post in the data array
                    foreach ($postComments['data'] as $comment) {
                        // Validate if the post info exists and has an id
                        if (isset($comment['id'])) {
                            $comment_id = substr($comment['id'], 0, 255);
                            // Create or update a post record in the database note the post_id is unique
                            comment::updateOrCreate(
                                ['comment_id' => $comment_id],
                                [
                                    'comment_id' => $comment_id,
                                    'post_id' => $post->id,
                                    'message' => $comment['message'],
                                    'created_at' => $comment['created_time'],
                                ]
                            );
                        }
                    }
                }
            } catch (\Exception $e) {
                // If an error occurs during the process, return an error response
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        return response()->json('success');
    }
    public function show($postId)
    {
        $comments = Comment::where('post_id', $postId)->with('analyseCommentaires')->get();
        // return response()->json($comments);
        return view('postcomment', compact('comments'));
    }
}
