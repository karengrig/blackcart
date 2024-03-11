<?php

namespace App\Services\Store\DTOs;

use App\Contracts\StoreDTO;
use Illuminate\Support\Collection;

class ProductDTO implements StoreDTO
{
    /**
     * Product ID
     *
     * @var int
     */
    public int $id;

    /**
     * Product name
     *
     * @var string
     */
    public string $name;

    /**
     * Is product available in stock
     *
     * @var bool
     */
    public bool $inStock;

    /**
     * Product variations
     *
     * @var Collection<ProductVariationDTO>
     */
    public Collection $variations;

    /**
     * Convert Product DTO into array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'in_stock' => $this->inStock,
            'variations' => $this->variations->toArray(),
        ];
    }
}
