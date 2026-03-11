# Día 1 — Instalación, Routing y Primer Endpoint JSON

**Objetivo:** tener una API respondiendo JSON en menos de 2 horas. El resto del día, entender a fondo el ciclo de vida de un request.

## Temario

| Tema / Subtema | Documentación Oficial | Tiempo | Peso |
| :--- | :--- | :--- | :--- |
| Instalación con Composer, estructura de carpetas  | [Installation](https://laravel.com/docs/12.x/installation)  | 1 h  | CRÍTICO  |
| routes/api.php — grupos, prefijos, versioning /v1  | [Routing](https://laravel.com/docs/12.x/routing) | 1.5 h | CRÍTICO  |
| Request lifecycle completo  | Request Lifecycle | 30 min | IMPORTANTE  |
| Responses — response()->json(), códigos HTTP  | [Responses](https://laravel.com/docs/12.x/responses)  | 1 h  | CRÍTICO  |
| Artisan CLI — comandos esenciales make:*  | Artisan Console  | 30 min  | IMPORTANTE  |

---

## ▶ PROYECTO: Health Check API

* **GET /api/v1/status** → `{ status: ok, version: 1.0, timestamp }`
* **GET /api/v1/ping** → respuesta en ms
* **POST /api/v1/echo** → devuelve el body recibido con validación básica
* Manejo de 404 y 500 con JSON (no HTML)


# Resumen de Ejecución: Día 1 — Health Check API

[cite_start]Este documento detalla los pasos prácticos realizados para cumplir con los objetivos del Día 1 del Plan de Estudios Profesional Laravel 12[cite: 1, 12]. [cite_start]Logramos tener una API respondiendo JSON estructurado y comprendimos el flujo de la petición[cite: 13, 14].

## 🎯 Objetivos Cumplidos
[cite_start]Desarrollamos el proyecto "Health Check API"[cite: 16, 60], logrando:
* [cite_start]Instalación con Composer y exploración de estructura[cite: 15].
* [cite_start]Uso de Artisan CLI para generar controladores[cite: 15].
* [cite_start]Configuración de `routes/api.php` con grupos y versioning `/v1`[cite: 15].
* [cite_start]Creación de endpoints devolviendo JSON con `response()->json()`[cite: 15].
* [cite_start]Intercepción de errores para asegurar que los códigos 404 y 500 devuelvan JSON en lugar de HTML.

---

## 🛠️ Paso a Paso de la Implementación

### 1. Instalación y Preparación del Entorno
Iniciamos el proyecto utilizando Composer y habilitamos el ruteo específico para APIs (requerido en Laravel 11/12):

```bash
composer create-project laravel/laravel health-check-api
cd health-check-api
php artisan install:api
2. Creación del Controlador
Utilizamos Artisan para generar el controlador estructurado dentro del namespace de la versión 1 de nuestra API:

Bash
php artisan make:controller Api/V1/HealthCheckController
3. Definición de Rutas (routes/api.php)
Agrupamos las rutas bajo el prefijo v1 para mantener un estándar profesional de versionado.

PHP
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\HealthCheckController;

Route::prefix('v1')->group(function () {
    Route::get('/status', [HealthCheckController::class, 'status']);
    Route::get('/ping', [HealthCheckController::class, 'ping']);
    Route::post('/echo', [HealthCheckController::class, 'echo']);
});
4. Lógica de los Endpoints (HealthCheckController.php)
Implementamos los tres métodos requeridos por el plan de estudios:


GET /api/v1/status: Retorna el estado ok, la versión y el timestamp.


GET /api/v1/ping: Calcula y retorna el tiempo de respuesta del servidor en milisegundos.


POST /api/v1/echo: Valida que exista el campo message en el body y lo devuelve exactamente igual.

PHP
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HealthCheckController extends Controller
{
    public function status()
    {
        return response()->json([
            'status' => 'ok',
            'version' => '1.0',
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public function ping()
    {
        return response()->json([
            'ping_ms' => round((microtime(true) - LARAVEL_START) * 1000, 2)
        ]);
    }

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
5. Configuración Global de Excepciones (bootstrap/app.php)
Para garantizar que la API nunca devuelva una vista HTML genérica al fallar, modificamos el manejador de excepciones.

Nota de debug: Inicialmente tuvimos un error de sintaxis por un ; faltante y luego un Error 500 porque PHP no encontraba la clase Request. Lo solucionamos encadenando correctamente el método ->create(); e inyectando el namespace completo \Illuminate\Http\Request.

PHP
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (\Illuminate\Http\Request $request) {
            return $request->is('api/*') || $request->wantsJson();
        });
    })->create();
6. Pruebas Realizadas y Validadas
Prueba POST: Se probó exitosamente POST /api/v1/echo en Postman enviando un body JSON, obteniendo un 200 OK.

Prueba 404: Se forzó un error navegando a una ruta inexistente (/api/v1/sarasa). Verificamos que Laravel interceptó correctamente la falla y devolvió una estructura JSON pura con el código HTTP 404 Not Found, confirmando el éxito del manejo de excepciones configurado en el paso anterior.