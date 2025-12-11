<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait ApiResponder {
    /**
     * Return success JSON response.
     *
     * @param string $message
     * @param mixed $data
     * @param int $code
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
     * @param string $message
     * @param mixed $data
     * @param int $code
     * @return JsonResponse
     */
    protected function error(string $message, $data = null, int $code = 400): JsonResponse {
        return response()->json([
            "status" => "error",
            "message" => $message,
            "data" => $data,
        ], $code > 0 ? $code : 400);
    }

    /**
     * Log exception securely (removes passwords) and includes stack trace.
     *
     * @param \Throwable $e
     * @param array $data
     * @return void
     */
    protected function logError(\Throwable $e, array $data = []): void {
        $sensitiveFields = ['password', 'password_confirmation', 'current_password', 'credit_card', 'cvv'];
        $cleanData = array_diff_key($data, array_flip($sensitiveFields));

        Log::error('API Error: ' . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'input_data' => $cleanData,
            'stack_trace' => $e->getTraceAsString()
        ]);
    }
}
