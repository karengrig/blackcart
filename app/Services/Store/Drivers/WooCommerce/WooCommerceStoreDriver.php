<?php

namespace App\Services\Store\Drivers\WooCommerce;

use App\Contracts\StoreDriver;
use App\Exceptions\InvalidDriverConfigurationException;
use App\Models\Store;
use App\Services\Store\Drivers\WooCommerce\DataMappers\ProductDataMapper;
use App\Services\Store\DTOs\ProductDTO;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Exception;

class WooCommerceStoreDriver implements StoreDriver
{
    private const URL_PREFIX = '/wp-json/wc/';
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
        if (!Arr::has($this->configuration, ['url', 'consumer_key', 'consumer_secret', 'version', 'units'])) {
            throw new InvalidDriverConfigurationException('Invalid driver configuration.');
        }
    }

    /**
     * Get list of products
     *
     * @return Collection<ProductDTO>
     * @throws Exception
     */
    public function listProducts(): Collection
    {
        $rawProducts = $this->request('GET', '/products');
        $units = $this->configuration['units'];
        return Collection::make($rawProducts)->map(fn($data) => ProductDataMapper::mapToDTO($data, $units));
    }

    /**
     * Send a request to WooCommerce API
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
        return Http::withBasicAuth($this->configuration['consumer_key'], $this->configuration['consumer_secret'])
            ->send($method, $url, $options)
            ->throw()
            ->json();
    }
}
