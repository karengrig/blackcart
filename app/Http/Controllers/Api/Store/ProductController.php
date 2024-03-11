<?php

namespace App\Http\Controllers\Api\Store;

use App\Exceptions\UnknownStoreDriverException;
use App\Http\Controllers\Api\BaseController;
use App\Models\Store;
use App\Services\Store\StoreService;
use Illuminate\Http\JsonResponse;

class ProductController extends BaseController
{
    /**
     * Get list of all products.
     *
     * @param Store $store
     * @return JsonResponse
     * @throws UnknownStoreDriverException
     */
    public function index(Store $store): JsonResponse
    {
        $storeService = new StoreService($store);
        $products = $storeService->listProducts();

        return $this->successResponse(data: [
            'products' => $products
        ]);
    }
}
