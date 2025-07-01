<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PagoController;

// Página principal de tienda
Route::get('', function () {
    return view('tienda');
});

// Vista del carrito
Route::get('/carrito', function () {
    return view('carrito');
});

// Obtener lista de productos (con búsqueda opcional)
Route::get('/productos', [ProductController::class, 'index']);

// Procesar pago (simulado o real)
Route::post('/pago', [PagoController::class, 'procesar']);

Route::get('/productos/{id}', [ProductController::class, 'show']);

