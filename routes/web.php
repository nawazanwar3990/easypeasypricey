<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('shopify')->group(function () {

    Route::get('home', [HomeController::class, 'home'])->name('shopify-home');
    Route::get('install', [HomeController::class, 'install'])->name('shopify-install');
    Route::get('token', [HomeController::class, 'token'])->name('shopify-token');
});
