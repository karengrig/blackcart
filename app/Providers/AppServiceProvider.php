<?php

namespace App\Providers;

use App\Services\Currency\CurrencyService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CurrencyService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $this->enableHttpMock();
    }

    /**
     * This method is added only for testing purposes. Please ignore this method while reviewing the task as this
     * should not be a part of the project.
     * Please check 6th point under Notes section in the README.md.
     *
     * @return void
     */
    private function enableHttpMock(): void
    {
        $shopifyMockedResponseFile = storage_path('testing/mocked-responses/shopify-products.json');
        $shopifyMockedResponse = file_get_contents($shopifyMockedResponseFile);
        Http::fake([
            'http://example.com/admin/api/2024-01/products.json' => Http::response($shopifyMockedResponse)
        ]);

        $woocommerceMockedResponseFile = storage_path('testing/mocked-responses/woocommerce-products.json');
        $woocommerceMockedResponse = file_get_contents($woocommerceMockedResponseFile);
        Http::fake([
            'http://example.com/wp-json/wc/v3/products' => Http::response($woocommerceMockedResponse)
        ]);
    }
}
