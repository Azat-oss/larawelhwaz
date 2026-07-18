<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController; // ОБЯЗАТЕЛЬНО ДОБАВИТЬ
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;


Route::get('/', [HomeController::class, 'index'])->name('home');


Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);


Route::get('/cart', function () {
    if (request()->ajax()) {
        return (new CartController)->getCart();
    }
    return view('basket.index'); 
})->name('cart');

Route::put('/cart/update/{productId}', [CartController::class, 'updateQuantity']);
Route::delete('/cart/remove/{productId}', [CartController::class, 'removeFromCart']);
Route::delete('/cart/clear', [CartController::class, 'clearCart']);


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// --------------------------------------------------------

require __DIR__.'/auth.php';