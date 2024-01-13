<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;



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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// 命名空間路由
// Route::namespace('Auth')->group(function () {
//     Auth::routes();
// });


// google登入
Route::get('login/{provider}', [LoginController::class, 'redirectToProvider'])->name('login.provider');;
Route::get('auth/{provider}/callback', [LoginController::class, 'handleProviderCallback']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 購物
Route::post('/addToCart/{id}', [ProductController::class, 'getAddToCart'])->name('addToCart')->middleware('auth');
Route::get('/cart', [ProductController::class, 'cart'])->name('cart')->middleware('auth');

Route::get('/shopping', [ProductController::class, 'returnShop'])->name('shopping');


// 顯示order頁面
Route::get('/order/new', [OrderController::class, 'new'])->name('new');
Route::post('/order/payment', [OrderController::class, 'store'])->name('payment');
Route::post('/callback', [OrderController::class, 'callback'])->name('callback');
Route::get('/success', [OrderController::class, 'redirectFromECpay'])->name('redirectFromECpay');
// 訂單查詢
Route::get('/ ', [OrderController::class, 'redirectFromECpay'])->name('redirectFromECpay');


// 後台管理路由
Route::prefix('admin')->group(function () {
    Route::get('/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.product');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products/store', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}/delete', [ProductController::class, 'delete'])->name('admin.products.delete');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.order');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.user');
});
