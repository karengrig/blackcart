<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class BaseController extends Controller
{
    /**
     * Send a success JSON response.
     *
     * @param string $message
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(string $message = 'Success', array $data = [], int $code = 200): JsonResponse
    {
        return ApiResponseHelper::successResponse($message, $data, $code);
    }

    /**
     * Send an error JSON response.
     *
     * @param string $error
     * @param array $errorDetails
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse(string $error = 'Error', array $errorDetails = [], int $code = 400): JsonResponse
    {
        return ApiResponseHelper::errorResponse($error, $errorDetails, $code);
    }
}
