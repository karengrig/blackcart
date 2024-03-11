<?php

namespace App\Services\Store\Drivers\WooCommerce\DataMappers;

use App\Services\Currency\Facades\CurrencyFacade;
use App\Services\Store\DTOs\ProductDTO;
use App\Services\Store\DTOs\ProductVariationDTO;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ProductDataMapper
{
    /**
     * Map WooCommerce product to ProductDTO.
     *
     * @param array $data
     * @param array $units
     * @return ProductDTO
     */
    public static function mapToDTO(array $data, array $units): ProductDTO
    {
        $productDTO = new ProductDTO();
        $productDTO->id = $data['id'];
        $productDTO->name = $data['name'];
        $productDTO->inStock = ($data['stock_status'] === 'instock');
        $productDTO->variations = self::getProductVariations($data['variations'], $units);
        return $productDTO;
    }

    /**
     * Get product variations.
     *
     * @param array $variations
     * @param array $units
     * @return Collection<ProductVariationDTO>
     */
    public static function getProductVariations(array $variations, array $units): Collection
    {
        $variationDTOs = Collection::make();

        foreach ($variations as $variation) {
            $variationDTO = new ProductVariationDTO();

            $variationDTO->id = $variation['id'];

            if ($variation['price']) {
                $variationDTO->prices = CurrencyFacade::getFormattedPricesForAllCurrencies(
                    (float)$variation['price'],
                    $units['currency'] ?? 'USD'
                );
            } else {
                $variationDTO->prices = [];
            }

            $variationDTO->inStock = ($variation['stock_status'] === 'instock');

            $sizeAttribute = Arr::first($variation['attributes'], fn($x) => $x['name'] === 'Size');
            $variationDTO->size = $sizeAttribute['option'] ?? null;

            $colorAttribute = Arr::first($variation['attributes'], fn($x) => $x['name'] === 'Color');
            $variationDTO->color = $colorAttribute['option'] ?? null;

            $variationDTO->weight = $variation['weight'] ? (float)$variation['weight'] : null;
            $variationDTO->weightUnit = $variationDTO->weight ? $units['weight'] : null;

            $variationDTOs->push($variationDTO);
        }

        return $variationDTOs;
    }
}
