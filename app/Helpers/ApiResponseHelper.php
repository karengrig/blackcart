<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponseHelper
{
    /**
     * Send a success JSON response.
     *
     * @param string $message
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public static function successResponse(string $message = 'Success', array $data = [], int $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ], $code);
    }

    /**
     * Send an error JSON response.
     *
     * @param string $error
     * @param array $errorDetails
     * @param int $code
     * @return JsonResponse
     */
    public static function errorResponse(string $error = 'Error', array $errorDetails = [], int $code = 400): JsonResponse
    {
        return response()->json([
            'error' => $error,
            'errorDetails' => $errorDetails,
            'code' => $code,
        ], $code);
    }
}
