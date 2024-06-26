<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalysePagesController;
use App\Http\Controllers\AnalysePosteController;
use App\Http\Controllers\AnalyseCommentsController; // Import du contrôleur pour l'analyse des commentaires
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/facebook/page/{page_id}/insights', [AnalysePagesController::class, 'getPageInsights']);
// Route pour obtenir les analyses des publications
Route::get('/facebook/posts/{post_id}/analytic', [AnalysePosteController::class, 'analysePoste']);

// Route pour obtenir les commentaires d'une publication
Route::get('/facebook/posts/{post_id}/comments', [AnalysePosteController::class, 'getPostComments']);

// Nouvelle route pour analyser les commentaires d'une publication spécifique
Route::get('/facebook/comments/{commentId}/analyse', [AnalyseCommentsController::class, 'analyseComments']);

Route::get('facebook/page/{pageId}/info', [PageController::class, 'getPageInfo']);

Route::get('facebook/posts', [PostController::class, 'getPostInfo']);

Route::get('facebook/posts/comments', [CommentaireController::class, 'getCommentsInfo']);
Route::get('/facebook/page/insights', [AnalysePagesController::class, 'getFacebookPageInsights']);
Route::get('/posts/{postId}/detailspost', [AnalysePosteController ::class, 'showdatails']);
