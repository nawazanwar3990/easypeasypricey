<?php

use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::any('reservation', [ReservationController::class, 'reservation']);
Route::any('reserve/order', [ReservationController::class, 'reserveOrder']);
