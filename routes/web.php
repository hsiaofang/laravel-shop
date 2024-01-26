<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Back\BackstageController;
use App\Http\Controllers\Back\BackproductController;
use App\Http\Controllers\Back\BackorderController;
use App\Http\Controllers\Back\BackuserController;
use App\Http\Middleware\SiteVisits;

// 主頁面
Route::get('/', function () {
    $products = Product::all();
    return view('welcome', ['products' => $products]);
})->middleware(SiteVisits::class);


Auth::routes();

// Google 登入
Route::get('login/{provider}', [LoginController::class, 'redirectToProvider'])->name('login.provider');
Route::get('auth/{provider}/callback', [LoginController::class, 'handleProviderCallback']);

// 會員首頁
Route::get('/home', [HomeController::class, 'index'])->name('home');

// 購物相關路由
Route::middleware('auth')->group(function () {
    Route::post('/addToCart/{id}', [ProductController::class, 'addToCart'])->name('addToCart');
    Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
    Route::post('/addTofavorite/{id}', [ProductController::class, 'addTofavorite'])->name('addTofavorite');
    Route::get('/favorite', [ProductController::class, 'favorite'])->name('favorite');
    Route::post('/removeFavorite/{id}', [ProductController::class, 'removeFavorite'])->name('removeFavorite');
});

Route::get('/shopping', [ProductController::class, 'returnShop'])->name('shopping');

// 訂單相關路由
Route::get('/order/new', [OrderController::class, 'new'])->name('new');
Route::post('/order/payment', [OrderController::class, 'store'])->name('payment');
Route::post('/callback', [OrderController::class, 'callback'])->name('callback');
Route::get('/success', [OrderController::class, 'redirectFromECpay'])->name('redirectFromECpay');
Route::get('/order', [OrderController::class, 'index'])->name('order');

// 後台管理路由
Route::prefix('admin')->group(function () {
    Route::get('/index', [BackstageController::class, 'index'])->name('admin.index');
    Route::prefix('products')->group(function () {
        Route::get('/', [BackproductController::class, 'index'])->name('admin.product');
        Route::get('/create', [BackproductController::class, 'createindex'])->name('admin.products.create');
        Route::post('/store', [BackproductController::class, 'create'])->name('admin.products.store');
        Route::get('products/{id}/edit', [BackproductController::class, 'edit'])->name('admin.products.edit');
        Route::put('products/{id}/update', [BackproductController::class, 'update'])->name('admin.products.update');
        Route::delete('products/{id}/delete', [BackproductController::class, 'delete'])->name('admin.products.delete');
    });

    Route::get('/orders', [BackorderController::class, 'index'])->name('admin.order');
    Route::get('/users', [BackuserController::class, 'index'])->name('admin.user');
});
