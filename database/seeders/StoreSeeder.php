<?php

namespace Database\Seeders;

use App\Enums\StoreDriverEnum;
use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::create([
            'platform' => 'shopify',
            'driver' => StoreDriverEnum::SHOPIFY->value,
            'configuration' => [
                'url' => 'http://example.com',
                'access_token' => 'dummy_token',
                'version' => '2024-01',
            ],
        ]);

        Store::create([
            'platform' => 'woocommerce',
            'driver' => StoreDriverEnum::WOOCOMMERCE->value,
            'configuration' => [
                'url' => 'http://example.com',
                'consumer_key' => 'ck_test',
                'consumer_secret' => 'cs_test',
                'version' => 'v3',
                'units' => [
                    'currency' => 'USD',
                    'weight' => 'g',
                ],
            ],
        ]);
    }
}
