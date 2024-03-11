<?php

namespace App\Services\Store;

use App\Contracts\StoreDriver;
use App\Enums\StoreDriverEnum;
use App\Exceptions\UnknownStoreDriverException;
use App\Models\Store;
use App\Services\Store\DTOs\ProductDTO;
use Illuminate\Support\Collection;

class StoreService
{
    private StoreDriver $driver;

    /**
     * Constructor.
     *
     * @param Store $store
     * @throws UnknownStoreDriverException
     */
    public function __construct(Store $store)
    {
        $this->buildDriver($store);
    }

    /**
     * Build the store driver.
     *
     * @param Store $store
     * @return void
     * @throws UnknownStoreDriverException
     */
    private function buildDriver(Store $store): void
    {
        $driverName = $store->driver;
        $driverEnum = StoreDriverEnum::tryFrom($driverName);
        if ($driverEnum === null) {
            throw new UnknownStoreDriverException($driverName);
        }
        $driverClass = $driverEnum->driverClass();
        $this->driver = new $driverClass($store);
    }

    /**
     * Get list of products.
     *
     * @return Collection<ProductDTO>
     */
    public function listProducts(): Collection
    {
        return $this->driver->listProducts();
    }
}
