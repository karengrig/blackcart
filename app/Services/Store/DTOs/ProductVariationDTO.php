<?php

namespace App\Services\Store\DTOs;

use App\Contracts\StoreDTO;

class ProductVariationDTO implements StoreDTO
{
    /**
     * Product variation ID
     *
     * @var int
     */
    public int $id;

    /**
     * Product variation prices in all currencies
     *
     * @var array
     */
    public array $prices;

    /**
     * Is product variation available in stock
     * @var bool
     */
    public bool $inStock;

    /**
     * Product variation size
     *
     * @var string|null
     */
    public ?string $size;

    /**
     * Product variation color
     *
     * @var string|null
     */
    public ?string $color;

    /**
     * Product variation weight
     *
     * @var float|null
     */
    public ?float $weight;

    /**
     * Product variation weight unit
     *
     * @var string|null
     */
    public ?string $weightUnit;

    /**
     * Convert Product variation DTO into array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'in_stock' => $this->inStock,
            'prices' => $this->prices,
            'size' => $this->size,
            'color' => $this->color,
            'weight' => $this->weight,
            'weight_unit' => $this->weightUnit,
        ];
    }
}
