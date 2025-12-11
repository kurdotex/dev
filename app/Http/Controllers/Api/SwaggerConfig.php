<?php


namespace App\Http\Controllers\Api;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Dev API",
 *     description="Documentación de la API Dev.",
 *     @OA\Contact(
 *         email="jose.vivas.ar@gmail.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Servidor local"
 * )
 *
 * @OA\SecurityScheme(
 * securityScheme="bearerAuth",
 * type="http",
 * scheme="bearer",
 * bearerFormat="Sanctum"
 * )
 */
class SwaggerConfig {}
