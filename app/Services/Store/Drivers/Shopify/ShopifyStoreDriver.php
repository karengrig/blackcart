<?php

namespace App\Services\Store\Drivers\Shopify;

use App\Contracts\StoreDriver;
use App\Exceptions\InvalidDriverConfigurationException;
use App\Models\Store;
use App\Services\Store\Drivers\Shopify\DataMappers\ProductDataMapper;
use App\Services\Store\DTOs\ProductDTO;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Exception;

class ShopifyStoreDriver implements StoreDriver
{
    private const URL_PREFIX = '/admin/api/';

    /**
     * Store driver configuration.
     *
     * @var array
     */
    private array $configuration;

    /**
     * Constructor.
     *
     * @param Store $store
     * @throws InvalidDriverConfigurationException
     */
    public function __construct(Store $store)
    {
        $this->configuration = $store->configuration;
        if (!Arr::has($this->configuration, ['url', 'access_token', 'version'])) {
            throw new InvalidDriverConfigurationException('Invalid driver configuration.');
        }
    }

    /**
     * Get list of products.
     *
     * @return Collection<ProductDTO>
     * @throws Exception
     */
    public function listProducts(): Collection
    {
        $response = $this->request('GET', '/products.json');
        $rawProducts = $response['products'] ?? [];
        return Collection::make($rawProducts)->map(fn($data) => ProductDataMapper::mapToDTO($data));
    }

    /**
     * Send a request to Shopify API.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $options
     * @return array
     * @throws Exception
     */
    private function request(string $method, string $endpoint, array $options = []): array
    {
        $url = $this->configuration['url'] . self::URL_PREFIX . $this->configuration['version'] . $endpoint;
        return Http::withHeaders([
            'X-Shopify-Access-Token' => $this->configuration['access_token']
        ])->send($method, $url, $options)->throw()->json();
    }
}
