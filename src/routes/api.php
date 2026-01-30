<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api as Api;

Route::prefix('articles')->group(function () {
    Route::get('/', [Api\ArticleController::class, 'index']);
    Route::get('/{id}', [Api\ArticleController::class, 'show']);
    Route::post('/', [Api\ArticleController::class, 'store']);

    Route::prefix('/{articleId}/comments')->group(function () {
        Route::get('/', [Api\CommentController::class, 'index']);
        Route::post('/', [Api\CommentController::class, 'store']);
    });
});
