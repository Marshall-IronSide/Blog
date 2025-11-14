<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::resource('articles', ArticleController::class);
