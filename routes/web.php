<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::controller(AuthController::class)->group(function() {
    Route::get('/login', 'loginView')->name('loginView');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::get('/register', 'registerView')->name('registerView');
    Route::post('/register', 'register')->name('register');
    Route::get('/home', 'home')->name('home');
    Route::post('/logout', 'logout')->name('logout');
});
