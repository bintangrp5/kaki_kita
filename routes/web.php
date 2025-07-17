<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DetailOrderController;
use App\Http\Controllers\CheckoutController;



Route::get('/', [HomepageController::class, 'index'])->name('home');
// Route::get('products', [HomepageController::class, 'products'])->name('products');
Route::get('product/{slug}', [HomepageController::class, 'product'])->name('product.show');
Route::get('categories_brand', [HomepageController::class, 'categories_brand']);
Route::get('category/{slug}', [HomepageController::class, 'category']);
Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('cart', [HomepageController::class, 'cart'])->name('cart.index');
Route::get('/categories/{id}', [ProductCategoryController::class, 'show'])->name('categories.show');


Route::patch('/products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');

Route::get('get.api.data', [ApiController::class, 'getApiData'])->name('get.api.data');


Route::group(['prefix' => 'customer'], function () {
    //Semua route yang ada di dalam sini,diakses dengan prefix customer
    Route::controller(CustomerAuthController::class)->group(function () {
        Route::group(['middleware' => 'check_customer_login'], function () {

            Route::get('login', 'login')->name('customer.login');
            Route::get('register', 'register')->name('customer.register');
            Route::post('login', 'store_login')->name('customer.store_login');
            Route::post('register', 'store_register')->name('customer.store_register');
        });
        Route::post('logout', 'logout')->name('customer.logout');
    });
});

// Group untuk customer cart
Route::group(['middleware' => ['is_customer_login']], function () {
    Route::controller(CartController::class)->group(function () {
        Route::post('cart/add', 'add')->name('cart.add');
        Route::patch('cart/update/{id}', 'update')->name('cart.update');
	    Route::delete('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    });
});


Route::middleware('auth:customer')->group(function () {
    Route::get('checkout', [HomepageController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});



// Group admin & dahboard
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {
    Route::view('/', 'dashboard')->name('dashboard');
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', ProductCategoryController::class)->except(['show']); 
    Route::resource('brands', BrandController::class);
    // Route::get('detail_order/{id}/show', [DetailOrderController::class, 'show'])->name('admin.detail_order.show');    
    // Route::resource('detail_order', DetailOrderController::class)->names('admin.detail_order');
    // Route::get('detail_order/{id}/show', [DetailOrderController::class, 'show'])->name('detail_order.show');

    
    Route::post('products/sync/{id}', [ProductController::class, 'sync'])->name('products.sync');
    Route::post('category/sync/{id}', [ProductCategoryController::class, 'sync'])->name('category.sync');
});



Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
