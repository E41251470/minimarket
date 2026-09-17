<?php

use App\Http\Controllers\productController;
use Illuminate\Support\Facades\Route;

// Halaman Frontend
Route::get('/', function () {
    return view('frontend.home');
})->name('home');

// Halaman Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Halaman Admin
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Route Product
Route::get('/posts', [productController::class, 'index']);
