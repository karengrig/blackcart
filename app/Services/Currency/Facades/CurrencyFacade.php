<?php

namespace App\Services\Currency\Facades;

use App\Services\Currency\CurrencyService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getFormattedPricesForAllCurrencies(float $fromPrice, string $fromCurrency)
 * @see CurrencyService
 */
class CurrencyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return CurrencyService::class;
    }
}
