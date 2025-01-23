<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponder {
    /**
     * Return success JSON response.
     *
     * @params string $message
     * @params int $code
     * @params $data
     * @return JsonResponse
     */
    protected function success(string $message, $data = null, int $code = 200): JsonResponse {
        return response()->json([
            "status" => "success",
            "message" => $message,
            "data" => $data,
        ], $code);
    }
    /**
     * Return error JSON response.
     *
     * @params string $message
     * @params int $code
     * @params $data
     * @return JsonResponse
     */
    protected function error(string $message, $data = null, int $code = 400): JsonResponse {
        return response()->json([
            "status" => "error",
            "message" => $message,
            "data" => $data,
        ], $code > 0 ? $code : 400);
    }

}