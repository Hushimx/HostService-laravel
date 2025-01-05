<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\VendorLoginController;
use App\Http\Controllers\vendors\ServiceOrdersController;
use App\Http\Controllers\vendors\DeliveryOrdersController;
use App\Http\Controllers\vendors\VendorServicesController;
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
    Auth::routes(['guard' => 'vendors']);
    Route::view('/user/password/forget', 'auth/passwords/email')->name('password.forgetpassword');

    // Global Routes
    Route::redirect('/', '/vendor/dashboard');
    Route::redirect('/home', '/vendor/dashboard')->name('home');

});

/*
|--------------------------------------------------------------------------
| guest vendors Only
|--------------------------------------------------------------------------
| these routes for guest of vendors can access only
|
|
*/

Route::group(
  [
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'guest:vendors']
  ],
function(){
  // vendor Authentication
  Route::get('vendor/login', [VendorLoginController::class, 'showLoginForm'])->name('vendor.login.form');
  // vendor Authentication
  Route::post('/vendor/login', [VendorLoginController::class, 'login'])->name('vendor.login');
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

    // vendor services
    Route::get('vendor-services', [VendorServicesController::class, 'index'])->name('services.index');
    Route::get('vendor-services/{serviceId}', [VendorServicesController::class, 'edit'])->name('services.edit'); // to edit the price

    // service orders
    Route::get('service-orders', [ServiceOrdersController::class, 'index'])->name('service.orders.index');

    // stores
    Route::get('vendor-stores', [StoresController::class, 'index'])->name('stores.index');
    Route::get('vendor-stores/edit/{storeId}', [StoresController::class, 'edit'])->name('stores.edit');
    Route::put('vendor-stores/update/{store}', [StoresController::class, 'update'])->name('stores.update');

    // profile edit
    Route::view('edit/profile', 'avendor.profile-edit')->name('profile.edit');

    // products Controller
    Route::resource('products', ProductController::class);

});


// Fallback route
Route::fallback(function () {
  return redirect('/home'); // Redirect to the desired route
});



