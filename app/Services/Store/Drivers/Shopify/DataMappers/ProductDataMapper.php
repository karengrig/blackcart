<?php

namespace App\Services\Store\Drivers\Shopify\DataMappers;

use App\Services\Currency\Facades\CurrencyFacade;
use App\Services\Store\DTOs\ProductDTO;
use App\Services\Store\DTOs\ProductVariationDTO;
use Illuminate\Support\Collection;

class ProductDataMapper
{
    /**
     * Map Shopify product to ProductDTO.
     *
     * @param array $data
     * @return ProductDTO
     */
    public static function mapToDTO(array $data): ProductDTO
    {
        $productDTO = new ProductDTO();
        $productDTO->id = $data['id'];
        $productDTO->name = $data['title'];
        $productDTO->variations = self::getProductVariations($data);
        $productDTO->inStock = $productDTO->variations->where('inStock', true)->isNotEmpty();

        return $productDTO;
    }

    /**
     * Get product variations.
     *
     * @param array $data
     * @return Collection<ProductVariationDTO>
     */
    public static function getProductVariations(array $data): Collection
    {
        $variationDTOs = Collection::make();
        $optionsCollection = Collection::make($data['options']);
        $sizeOptionPosition = $optionsCollection->where('name', 'Size')->value('position');
        $colorOptionPosition = $optionsCollection->where('name', 'Color')->value('position');

        foreach ($data['variants'] as $variation) {
            $variationDTO = new ProductVariationDTO();
            $variationDTO->id = $variation['id'];
            $currency = $variation['presentment_prices'][0]['price']['currency_code'];

            if ($variation['price']) {
                $variationDTO->prices = CurrencyFacade::getFormattedPricesForAllCurrencies(
                    (float)$variation['price'],
                    $currency
                );
            } else {
                $variationDTO->prices = [];
            }

            $variationDTO->inStock = $variation['inventory_quantity'] > 0;

            $variationDTO->color = $colorOptionPosition !== null ? $variation["option{$colorOptionPosition}"] : null;
            $variationDTO->size = $sizeOptionPosition !== null ? $variation["option{$sizeOptionPosition}"] : null;
            $variationDTO->weight = $variation['weight'] ?? null;
            $variationDTO->weightUnit = $variation['weight_unit'] ?? null;

            $variationDTOs->push($variationDTO);
        }

        return $variationDTOs;
    }
}
