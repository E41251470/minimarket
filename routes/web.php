<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CashierController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\TransactionController;

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
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');


        /*
        |--------------------------------------------------------------------------
        | PRODUCTS
        |--------------------------------------------------------------------------
        */

        Route::resource('products', ProductController::class)
            ->names([
                'index'   => 'admin.products.index',
                'create'  => 'admin.products.create',
                'store'   => 'admin.products.store',
                'show'    => 'admin.products.show',
                'edit'    => 'admin.products.edit',
                'update'  => 'admin.products.update',
                'destroy' => 'admin.products.destroy',
            ]);


        /*
        |--------------------------------------------------------------------------
        | CASHIER
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

        Route::post('/cashier/hold', [
            CashierController::class,
            'hold',
        ])->name('admin.cashier.hold');

        Route::post('/cashier/pay', [
            CashierController::class,
            'pay',
        ])->name('admin.cashier.pay');

        Route::get('/cashier/held/{transaction}', [
            CashierController::class,
            'getHeldTransaction',
        ])->name('admin.cashier.held');

        Route::delete('/cashier/held/{transaction}', [
            CashierController::class,
            'deleteHeldTransaction',
        ])->name('admin.cashier.held.delete');


        /*
        |--------------------------------------------------------------------------
        | TRANSACTIONS
        |--------------------------------------------------------------------------
        */

        Route::get('/transactions', [
            TransactionController::class,
            'index',
        ])->name('admin.transactions.index');


        /*
        |--------------------------------------------------------------------------
        | INVOICE PDF
        |--------------------------------------------------------------------------
        */

        Route::get('/transactions/{id}/invoice', [
            InvoiceController::class,
            'download',
        ])->name('admin.transactions.invoice');

    });
