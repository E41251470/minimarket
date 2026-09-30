<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CashierController;


/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('frontend.home');
})->name('frontend');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        Route::resource('products', ProductController::class)
            ->names('admin.products');


        /*
        |--------------------------------------------------------------------------
        | Cashier
        |--------------------------------------------------------------------------
        */

        Route::get('/cashier', [
            CashierController::class,
            'index',
        ])->name('admin.cashier.index');


        Route::get('/cashier/search-product', [
            CashierController::class,
            'searchProduct',
        ])->name('admin.cashier.search-product');


        /*
        |--------------------------------------------------------------------------
        | Hold Transaction
        |--------------------------------------------------------------------------
        */

        Route::post('/cashier/hold', [
            CashierController::class,
            'hold',
        ])->name('admin.cashier.hold');


        /*
        |--------------------------------------------------------------------------
        | Payment
        |--------------------------------------------------------------------------
        */

        Route::post('/cashier/pay', [
            CashierController::class,
            'pay',
        ])->name('admin.cashier.pay');


        /*
        |--------------------------------------------------------------------------
        | Held Transactions
        |--------------------------------------------------------------------------
        */

        Route::get('/cashier/held/{transaction}', [
            CashierController::class,
            'getHeldTransaction',
        ])->name('admin.cashier.held');


        /*
        |--------------------------------------------------------------------------
        | Delete Held Transaction
        |--------------------------------------------------------------------------
        */

        Route::delete('/cashier/held/{transaction}', [
            CashierController::class,
            'deleteHeldTransaction',
        ])->name('admin.cashier.held.delete');

    });
