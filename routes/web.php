<?php

use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Auth\VendorLoginController;
use App\Models\City;

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
    // users Authentication
    Auth::routes();
    Route::view('/user/password/forget', 'auth/passwords/email')->name('password.forgetpassword');

    // vendor Authentication
    Route::get('vendor/login', [VendorLoginController::class, 'showLoginForm'])->name('vendor.login.form');
    Route::post('vendor/login', [VendorLoginController::class, 'login'])->name('vendor.login');
    Route::post('vendor/logout', [VendorLoginController::class, 'logout'])->name('vendor.logout');
    // vendor dashboard
    Route::get('/vendor/dashboard', function () {
        return view('avendor.dashboard');
    })->name('vendor.dashboard');

    // Global Routes
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/countries', function () {
        return Country::all();
    });

    Route::get('/cities', function () {
        return City::all();
    });

    Route::view('admin/dashboard', 'admin.dashboard')->name('admin.dashboard');

    Route::get('/users', function () {
        return view('page_default');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});








