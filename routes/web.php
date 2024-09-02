<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;

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
Route::post('/add', [CartController::class, 'addToCart']);
//});


Route::get('/register', function() {
    if (auth()->check()) {
        return redirect('/');
    }

    //$controller = new RegisterController();
    //return $controller->showRegistrationForm();
    return view('auth.register');
})->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::get('/login', function () {
    if (auth()->check()) {
        return redirect('/');
    }
    
    //$controller = new LoginController();
    //return $controller->showLoginForm();
    return view('auth.login');
})->name('login');
Route::post('/login', [LoginController::class, 'login']);


Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

