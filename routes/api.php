<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostArticleController;

Route::post('/post-article', [PostArticleController::class, 'store']);
