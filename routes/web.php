<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DraftController;

Route::middleware('throttle:60,1')->group(function () {
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{category}/{title}', [ArticleController::class, 'show'])->name('detail');
});

// Route::group(['prefix' => 'admin-cms/articles'], function () {
//     Route::get('', [ArticleController::class, 'datatable'])->name('articles.index');
//     Route::get('/create', [ArticleController::class, 'create'])->name('articles.create');
//     Route::post('', [ArticleController::class, 'store'])->name('articles.store');
//     Route::get('/edit/{article}', [ArticleController::class, 'edit'])->name('articles.edit');
//     Route::put('/{article}', [ArticleController::class, 'update'])->name('articles.update');
//     Route::delete('/{articleId}', [ArticleController::class, 'destroy']);
//     Route::patch('/{articleId}/status', [ArticleController::class, 'updateStatus']);
// });

Route::group(['prefix' => 'admin-cms/drafts'], function () {
    Route::get('', [DraftController::class, 'datatable'])->name('drafts.index');
    Route::get('/new', [DraftController::class, 'new'])->name('drafts.new');
    Route::get('/create/{draft}', [DraftController::class, 'create'])->name('drafts.create');
    Route::post('', [DraftController::class, 'store'])->name('drafts.store');
    Route::get('/edit/{draft}', [DraftController::class, 'edit'])->name('drafts.edit');
    Route::put('/{draft}', [DraftController::class, 'update'])->name('drafts.update');
    Route::delete('/{draftId}', [DraftController::class, 'destroy']);
    Route::patch('/post/draft/{draftId}/{type}', [DraftController::class, 'postDraft']);
});