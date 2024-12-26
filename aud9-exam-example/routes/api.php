<?php

use App\Http\Controllers\JetController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('jets', JetController::class);
Route::apiResource('reviews', ReviewController::class)->only('index', 'store', 'show');
Route::put('/reviews/{review}/approve', [ReviewController::class, 'approveReview']);
Route::put('/reviews/{review}/decline', [ReviewController::class, 'declineReview']);
