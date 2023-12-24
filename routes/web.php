<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;



Route::get('/', function () {
    return view('welcome');
});

use App\Models\User;
Route::get('/test-database-connection', function () {
    $users = User::all();
    return $users;
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/addtocart', [CartController::class, 'addToCart'])->name('addToCart');


