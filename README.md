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