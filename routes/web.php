<?php

use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\VendorLoginController;
use App\Http\Controllers\vendors\DeliveryOrdersController;
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
    // users Authentication
    Auth::routes();
    Route::view('/user/password/forget', 'auth/passwords/email')->name('password.forgetpassword');

    // vendor Authentication
    Route::post('/vendor/login', [VendorLoginController::class, 'login'])->name('vendor.login');

    // Route::resource('vendors', VendorController::class);

    // Route::view('admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
    // Global Routes
    Route::view('/', 'welcome');
    Route::view('/home', 'welcome')->name('home');

    Route::get('/cities', function () {
        return City::all();
    });


    Route::get('/users', function () {
        return view('page_default');
    });
});

/*
|--------------------------------------------------------------------------
| guest Routes Only Can Access
|--------------------------------------------------------------------------
| these routes for guest can access only
|
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'guest']
    ],
function(){
    // vendor Authentication
    Route::get('vendor/login', [VendorLoginController::class, 'showLoginForm'])->name('vendor.login.form');
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

    // vendor dashboard
    Route::view('/vendor/dashboard', 'avendor.dashboard')->name('vendor.dashboard');
    Route::post('/vendor/logout', [VendorLoginController::class, 'logout'])->name('vendor.logout');


    // deliveryOrders
    Route::get('delivery-orders', [DeliveryOrdersController::class, 'index'])->name('deliveryOrders.index');
    Route::get('delivery-orders/delivery-order-items/{id}', [DeliveryOrdersController::class, 'deliveryOrderItems'])->name('deliveryOrders.deliveryOrderItems');

    Route::resource('products', ProductController::class);

});

// Fallback route
Route::fallback(function () {
    return redirect('/home'); // Redirect to the desired route
});



