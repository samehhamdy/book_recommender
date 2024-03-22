<?php

use App\Http\Controllers\Api\BookRecommenderController;
use App\Http\Controllers\Api\IntervalsController;
use Illuminate\Support\Facades\Route;

Route::post('new-read-interval', IntervalsController::class);
Route::get('recommended-books', BookRecommenderController::class);
