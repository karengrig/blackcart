<?php

namespace App\Services\Currency;

use App\Exceptions\InvalidCurrencyException;
use Illuminate\Support\Arr;

class CurrencyService
{
    /**
     * All supported currencies.
     *
     * @var array
     */
    private array $currencies;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->currencies = config('currencies.currencies');
    }

    /**
     * Get formatted prices for all currencies.
     *
     * @param float $fromPrice
     * @param string $fromCurrency
     * @return string[]
     * @throws InvalidCurrencyException
     */
    public function getFormattedPricesForAllCurrencies(float $fromPrice, string $fromCurrency): array
    {
        if (!array_key_exists($fromCurrency, $this->currencies)) {
            throw new InvalidCurrencyException("Unknown currency '$fromCurrency'.");
        }

        $result = [
            $fromCurrency => $this->getFormattedAmount($fromCurrency, $fromPrice),
        ];

        $otherCurrencies = Arr::except($this->currencies, $fromCurrency);
        $exchangeRateForFromCurrency = $this->currencies[$fromCurrency]['exchange_rate'];
        $basePrice = $fromPrice / $exchangeRateForFromCurrency;

        foreach ($otherCurrencies as $currency => $data) {
            $exchangeRate = $data['exchange_rate'];
            $exchangedPrice = $basePrice * $exchangeRate;
            $result[$currency] = $this->getFormattedAmount($currency, $exchangedPrice);
        }

        return $result;
    }

    /**
     * Get ceil formatted amount for currency.
     *
     * @param string $currency
     * @param float $amount
     * @return string
     */
    private function getFormattedAmount(string $currency, float $amount): string
    {
        $decimalPoints = $this->currencies[$currency]['decimal_points'];
        $multiplier = pow(10, $decimalPoints);
        $ceilNumber = ceil($multiplier * $amount) / $multiplier;

        return number_format($ceilNumber, $decimalPoints, '.', '');
    }
}
