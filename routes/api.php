<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PreferenceController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/resetPassword', [AuthController::class, 'resetPassword']);
    Route::get('/logout', [AuthController::class, 'logout']);
    // Route::get('/user', [AuthController::class, 'show']);

    // Article
    Route::get('/getAllArticles/{pages?}', [ArticleController::class, 'index']);
    Route::get('/getArticleById/{id}', [ArticleController::class, 'show']);
    Route::post('/createArticle', [ArticleController::class, 'store']);
    Route::get('/getFilteredArticles', [ArticleController::class, 'getFilteredArticles']);

    // Preference
    Route::get('/getPreferences', [PreferenceController::class, 'getPreferences']);
    Route::post('/setPreferences', [PreferenceController::class, 'setPreferences']);
    Route::get('/fetchPersonalizedFeed', [PreferenceController::class, 'fetchPersonalizedFeed']);
});

