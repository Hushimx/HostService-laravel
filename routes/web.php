<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Global Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ],
function(){
    // Authentication
    Auth::routes();
    Route::view('/user/password/forget', 'auth/passwords/email')->name('password.forgetpassword');

    // Global Routes
    Route::get('/', function () {
        return view('welcome');
    });
    Route::view('admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::get('/users', function () {
        return view('page_default');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});








