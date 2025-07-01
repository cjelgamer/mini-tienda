<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }


    public function show($id)
{
    $producto = Product::find($id);
    if (!$producto) {
        return response()->json(['mensaje' => 'Producto no encontrado'], 404);
    }
    return response()->json($producto);
}

}




