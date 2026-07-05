<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('categories', CategoryController::class);

Route::resource('products', ProductController::class);

Route::get('basket', [BasketController::class, 'index'])->name('basket.index');
// Маршруты для API работы с корзиной (AJAX)
Route::get('/cart', [CartController::class, 'getCart']); // Получение данных корзины
Route::put('/cart/update/{productId}', [CartController::class, 'update']); // Обновление количества
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove']); // Удаление товара
Route::delete('/cart/clear', [CartController::class, 'clear']); // Очистка корзины


// Отдаем HTML страницу
Route::get('/cart', function () {
    return view('basket.index'); // Так как ваш файл лежит в views/basket/index.blade.php
});

// AJAX запросы
Route::put('/cart/update/{productId}', [CartController::class, 'updateQuantity']);
Route::delete('/cart/remove/{productId}', [CartController::class, 'removeFromCart']);
Route::delete('/cart/clear', [CartController::class, 'clearCart']);

// Умный маршрут: отдает HTML для браузера и JSON для AJAX
Route::get('/cart', function () {
    if (request()->ajax()) {
        // Если запрос пришел от JavaScript — отдаем данные корзины
        return (new \App\Http\Controllers\Api\CartController)->getCart();
    }
    // Если зашел человек в браузере — показываем красивую страницу
    return view('basket.index'); 
})->name('cart');