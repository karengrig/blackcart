<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class GeneralController extends BaseController
{
    /**
     * The index endpoint.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $name = config('app.name');

        return $this->successResponse('Success', [
            'name' => $name,
        ]);
    }
}
