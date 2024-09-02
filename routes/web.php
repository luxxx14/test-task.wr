<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CatalogController::class, 'showCatalog']);

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'deleteCartItem'])->name('cart.remove');
    Route::post('/cart/add/{id}', [CartController::class, 'addCartItem'])->name('cart.add');

    Route::post('/order/confirm', [OrderController::class, 'confirmOrder'])->name('order.confirm');
});


Route::get('/register', function() {
    if (auth()->check()) {
        return redirect('/');
    }
    return view('auth.register');
})->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::get('/login', function () {
    if (auth()->check()) {
        return redirect('/');
    }

    return view('auth.login');
})->name('login');
Route::post('/login', [LoginController::class, 'login']);


Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

