<?php

namespace Tests\Feature\Store\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ListProductsTest extends TestCase
{
    use RefreshDatabase;

    public bool $seed = true;

    public function testShopifyProducts(): void
    {
        $shopifyMockedResponseFile = storage_path('testing/mocked-responses/shopify-products.json');
        $shopifyMockedResponse = file_get_contents($shopifyMockedResponseFile);
        Http::fake([
            'http://example.com/admin/api/2024-01/products.json' => Http::response($shopifyMockedResponse)
        ]);

        $response = $this->get('/stores/1/products');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data.products');
        $response->assertJsonCount(4, 'data.products.0.variations');
        $response->assertJsonCount(1, 'data.products.1.variations');
    }

    public function testWooCommerceProducts(): void
    {
        $woocommerceMockedResponseFile = storage_path('testing/mocked-responses/woocommerce-products.json');
        $woocommerceMockedResponse = file_get_contents($woocommerceMockedResponseFile);
        Http::fake([
            'http://example.com/wp-json/wc/v3/products' => Http::response($woocommerceMockedResponse)
        ]);

        $response = $this->get('/stores/2/products');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data.products');
        $response->assertJsonCount(2, 'data.products.0.variations');
        $response->assertJsonCount(0, 'data.products.1.variations');
    }
}
