<?php

use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\VendorLoginController;
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
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'guest' ]
    ],
function(){
    // vendor Authentication
    Route::get('vendor/login', [VendorLoginController::class, 'showLoginForm'])->name('vendor.login.form');
});
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
    Route::post('vendor/login', [VendorLoginController::class, 'login'])->name('vendor.login');
    Route::post('vendor/logout', [VendorLoginController::class, 'logout'])->name('vendor.logout');

    // Route::resource('vendors', VendorController::class);

    // vendor dashboard
    Route::get('/vendor/dashboard', function () {
        return view('avendor.dashboard');
    })->name('vendor.dashboard');

    // Global Routes
    Route::get('/', function () {
        return view('welcome');
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


/*
|--------------------------------------------------------------------------
| Vendors Web Routes Only Can Access
|--------------------------------------------------------------------------
| these routes for vendors can acces only
|
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'vendor']
    ],
function(){
    Route::view('/', 'avendor.dashboard');

    Route::resource('products', ProductController::class);
});





