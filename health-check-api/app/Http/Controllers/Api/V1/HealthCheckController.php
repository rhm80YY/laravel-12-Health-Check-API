<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HealthCheckController extends Controller
{
    // GET /api/v1/status → { status: ok, version: 1.0, timestamp }
    /*
     * Devuelve un JSON con el estado de la API, la versión y la fecha actual en formato ISO 8601.
     */
    public function status()
    {
        return response()->json([
            'status' => 'ok',
            'version' => '1.0',
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    // GET /api/v1/ping → respuesta en ms
    /*
     * Calcula el tiempo total de respuesta de la API.
     * Resta el tiempo en que Laravel inició la petición (LARAVEL_START)
     * del tiempo actual microtime(true), lo multiplica por 1000 para 
     * convertirlo a milisegundos y lo redondea a 2 decimales.
     */
    public function ping()
    {
        return response()->json([
            'ping_ms' => round((microtime(true) - LARAVEL_START) * 1000, 2)
        ]);
    }

    // POST /api/v1/echo → devuelve el body recibido con validación básica
    /*
     * Valida que el body recibido contenga un campo 'message' de tipo string.
     * Si la validación es exitosa, devuelve el body recibido.
     */
    public function echo(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        return response()->json([
            'echo' => $validated
        ]);
    }
}
