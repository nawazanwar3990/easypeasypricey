<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

//Routes for App Install

Route::get('shopify/home', [HomeController::class, 'home'])->name('home');
Route::get('shopify/install', [HomeController::class, 'install'])->name('install');
Route::get('shopify/token', [HomeController::class, 'token'])->name('token');
