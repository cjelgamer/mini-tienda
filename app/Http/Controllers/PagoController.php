<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function procesar(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string',
            'tarjeta' => 'required|string|max:16',
            'vencimiento' => 'required|string',
            'cvc' => 'required|string|max:4'
        ]);

        // Simular respuesta exitosa
        return response()->json([
            'mensaje' => '✅ Pago simulado correctamente',
            'status' => 'ok'
        ]);
    }
}
