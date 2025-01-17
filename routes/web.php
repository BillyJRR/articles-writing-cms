<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::middleware('throttle:60,1')->group(function () {
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{category}/{title}', [ArticleController::class, 'show'])->name('detail');
});

Route::group(['prefix' => 'admin-cms/articles'], function () {
    Route::get('', [ArticleController::class, 'datatable'])->name('articles.index');
    Route::get('/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/edit/{article}', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/{articleId}', [ArticleController::class, 'destroy']);
    Route::patch('/{articleId}/status', [ArticleController::class, 'updateStatus']);
});
