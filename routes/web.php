<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\VendorLoginController;
use App\Http\Controllers\vendorsDashboardController;
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
    # users Authentication
    Auth::routes(['guard' => 'vendors']);
    Route::view('/user/password/forget', 'auth/passwords/email')->name('password.forgetpassword');

    # Global Routes
    Route::redirect('/', '/vendor/dashboard');
    Route::redirect('/home', '/vendor/dashboard')->name('home');

    # guest vendors Only
    Route::middleware('guest:vendors')->group(function () {
      // vendor Authentication
      Route::get('vendor/login', [VendorLoginController::class, 'showLoginForm'])->name('vendor.login.form');
      // vendor Authentication
      Route::post('/vendor/login', [VendorLoginController::class, 'login'])->name('vendor.login');
    });

    # Vendors Routes Only Can Access
    Route::middleware('vendor')->group(function () {
      // vendor dashboard
      Route::get('/vendor/dashboard', [vendorsDashboardController::class, 'index'])->name('vendor.dashboard');

      Route::post('/vendor/logout', [VendorLoginController::class, 'logout'])->name('vendor.logout');

      // deliveryOrders
      Route::get('delivery-orders', [DeliveryOrdersController::class, 'index'])->name('deliveryOrders.index');
      Route::get('delivery-orders/delivery-order-items/{id}', [DeliveryOrdersController::class, 'deliveryOrderItems'])->name('deliveryOrders.deliveryOrderItems');

      // vendor services
      Route::get('vendor-services', [VendorServicesController::class, 'index'])->name('services.index');
      Route::get('vendor-services/{serviceId}', [VendorServicesController::class, 'edit'])->name('services.edit'); // to edit the price
      Route::get('vendor-services/edit/{id}', [VendorServicesController::class, 'editDesc'])->name('service.edit.description');
      Route::put('vendor-services/update/{id}', [VendorServicesController::class, 'updateDesc'])->name('service.update.description');

      // service orders
      Route::get('service-orders', [ServiceOrdersController::class, 'index'])->name('service.orders.index');

      // stores
      Route::get('vendor-stores', [StoresController::class, 'index'])->name('stores.index');
      Route::get('vendor-stores/edit/{storeId}', [StoresController::class, 'edit'])->name('stores.edit');
      Route::put('vendor-stores/update/{store}', [StoresController::class, 'update'])->name('stores.update');

      // profile edit
      Route::view('edit/profile', 'avendor.profile-edit')->name('profile.edit');

      // products by storeId only
      Route::get('products/bystore/{id}', [ProductController::class, 'storeProducts'])->name('products.store.index');

      // products Controller
      Route::resource('products', ProductController::class);
    });

});

# Fallback route
Route::fallback(function () {
  return redirect('/home'); // Redirect to the desired route
});



