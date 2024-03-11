<?php

namespace App\Contracts;

use App\Models\Store;
use Illuminate\Support\Collection;

interface StoreDriver
{
    /**
     * Constructor.
     *
     * @param Store $store
     */
    public function __construct(Store $store);

    /**
     * Get list of products.
     *
     * @return Collection<StoreDTO>
     */
    public function listProducts(): Collection;
}
