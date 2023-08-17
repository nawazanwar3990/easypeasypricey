<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

//Routes for App Install

Route::prefix('shopify')->group(function () {
    Route::get('home', [HomeController::class, 'home'])->name('home');
    Route::get('install', [HomeController::class, 'install'])->name('install');
    Route::get('token', [HomeController::class, 'token'])->name('token');

    Route::post('orders/edit', [OrderController::class, 'edit'])->name('shopify.orders.edit');
    Route::post('orders/update', [OrderController::class, 'update'])->name('shopify.orders.update');
});
