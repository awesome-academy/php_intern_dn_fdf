<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\ImageProductController;
use App\Http\Controllers\Admin\SuggestController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('Admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('excute.login');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');

        Route::resource('users', '\App\Http\Controllers\Admin\UserController')->only([
            'index',
            'show',
            'destroy',
        ]);

        Route::resource('categories', '\App\Http\Controllers\Admin\CategoryController')->except([
            'show',
        ]);

        Route::resource('products', '\App\Http\Controllers\Admin\ProductController');

        Route::resource('orders', '\App\Http\Controllers\Admin\OrderController')->only([
            'index',
            'show',
            'update',
        ]);

        Route::resource('suggests', '\App\Http\Controllers\Admin\SuggestController')->only([
            'index',
            'show',
        ]);

        Route::put('/suggests/{suggest}/approve', [SuggestController::class, 'approve'])->name('suggest.approve');
        Route::put('/suggests/{suggest}/defuse', [SuggestController::class, 'defuse'])->name('suggest.refuse');

        Route::post('/products/{product}/image', [ImageProductController::class, 'store'])->name('image.store');
        Route::delete('/products/{id}/image', [ImageProductController::class, 'destroy'])->name('image.destroy');
    });
});
