<?php

use App\Http\Controllers\Api\BookRecommenderController;
use App\Http\Controllers\Api\IntervalsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('new-read-interval', IntervalsController::class);
Route::get('recommended-books', BookRecommenderController::class);
