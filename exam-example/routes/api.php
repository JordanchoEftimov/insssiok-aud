<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\YachtController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('yachts', YachtController::class)->only('index', 'store', 'update', 'destroy');

Route::apiResource('reservations', ReservationController::class)->only('index', 'store');
Route::prefix('/reservations/{reservation}')->group(function () {
    Route::put('/confirm', [ReservationController::class, 'confirmReservation']);
    Route::put('/cancel', [ReservationController::class, 'cancelReservation']);
});

Route::apiResource('reviews', ReviewController::class)->only('index', 'store');
