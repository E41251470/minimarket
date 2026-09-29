<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController;

Route::get('/', function () {
    return view('frontend.home');
})->name('frontend');

Route::middleware('guest')->group(function () {
    Route::get('/login', [
        AuthController::class,
        'showLogin',
    ])->name('login');

    Route::post('/login', [
        AuthController::class,
        'login',
    ])->name('login.process');
});

Route::post('/logout', [
    AuthController::class,
    'logout',
])->middleware('auth')->name('logout');


Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::resource('products', ProductController::class)
            ->names('admin.products');
    });
