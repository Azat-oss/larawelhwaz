<?php

use App\Http\Controllers\Api\CartController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Маршруты корзины
Route::get('/cart', [CartController::class, 'getCart']);
Route::post('/cart/add/{product}', [CartController::class, 'addToCart']);
Route::delete('/cart/remove/{product}', [CartController::class, 'removeFromCart']);
Route::put('/cart/update/{product}', [CartController::class, 'updateQuantity']);
Route::delete('/cart/clear', [CartController::class, 'clearCart']);

// Поиск товаров
Route::get('/search', function (Request $request) {
    $query = $request->get('q');
    if (strlen($query) < 2) {
        return response()->json(['status' => 'success', 'data' => []]);
    }

    $products = Product::with('category')
        ->where('name', 'like', "%{$query}%")
        ->orWhere('description', 'like', "%{$query}%")
        ->limit(10)
        ->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'category' => $product->category?->name
            ];
        });

    return response()->json([
        'status' => 'success',
        'data' => $products
    ]);
});

// Получение товара для быстрого просмотра
Route::get('/product/{product}', function (Product $product) {
    return response()->json([
        'status' => 'success',
        'data' => [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'old_price' => $product->old_price,
            'image' => $product->image,
            'category' => $product->category?->name,
            'tags' => $product->tags,
            'created_at' => $product->created_at
        ]
    ]);
});
