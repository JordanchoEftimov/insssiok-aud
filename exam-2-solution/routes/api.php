<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('events', EventController::class);
Route::apiResource('reservations', ReservationController::class)->only('store');
Route::prefix('/reservations/{reservation}')->group(function () {
    Route::put('/confirm', [ReservationController::class, 'confirm']);
    Route::put('/cancel', [ReservationController::class, 'cancel']);
});
