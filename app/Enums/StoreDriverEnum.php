<?php

namespace App\Enums;

use App\Services\Store\Drivers\Shopify\ShopifyStoreDriver;
use App\Services\Store\Drivers\WooCommerce\WooCommerceStoreDriver;

enum StoreDriverEnum: string
{
    case SHOPIFY = 'shopify';
    case WOOCOMMERCE = 'woocommerce';

    /**
     * Get driver class.
     *
     * @return string
     */
    public function driverClass(): string
    {
        return match ($this) {
            self::SHOPIFY => ShopifyStoreDriver::class,
            self::WOOCOMMERCE => WooCommerceStoreDriver::class,
        };
    }
}
