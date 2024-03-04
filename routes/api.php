<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalysePagesController;
use App\Http\Controllers\AnalysePosteController;
use App\Http\Controllers\AnalyseCommentsController; // Import du contrôleur pour l'analyse des commentaires

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

Route::get('/facebook/page-insights', [AnalysePagesController::class, 'getPageInsights']);
Route::get('/facebook/{post_id}/insights', [AnalysePagesController::class, 'getPageInsights']);
Route::get('/facebook/page', [AnalysePagesController::class, 'getPageInsights']);

// Route pour obtenir les analyses des publications
Route::get('/facebook/posts/{post_id}/analytics', [AnalysePosteController::class, 'getPostAnalytics']);

// Route pour obtenir les commentaires d'une publication
Route::get('/facebook/posts/{post_id}/comments', [AnalysePosteController::class, 'getPostComments']);

// Nouvelle route pour analyser les commentaires d'une publication spécifique
Route::get('/facebook/posts/{commentId}/comments/analyse', [AnalyseCommentsController::class, 'analyseComments']);

