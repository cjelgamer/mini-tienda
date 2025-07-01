<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/tienda', function () {
    return view('tienda');
});



Route::get('/carrito', function () {
    return view('carrito');
});


// Ruta para obtener productos (ya que no te funcionaba en api.php)
Route::get('/productos', [ProductController::class, 'index']);
