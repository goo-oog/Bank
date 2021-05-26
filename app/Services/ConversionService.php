<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Currency;
use App\Repositories\CurrencyRatesRepository;

class ConversionService
{
    private CurrencyRatesRepository $currencyRates;

    public function __construct(CurrencyRatesRepository $currencyRates)
    {
        $this->currencyRates = $currencyRates;
    }

    public function do(string $fromSymbol, string $toSymbol, $amount): int
    {
        $this->currencyRates->getRates();
        $fromCurrency = Currency::find($fromSymbol);
        $toCurrency = Currency::find($toSymbol);
        if ($fromSymbol === 'EUR') {
            $result = $toCurrency->rate * $amount;
        } elseif ($toSymbol === 'EUR') {
            $result = $amount / $fromCurrency->rate;
        } else {
            $result = $amount * $toCurrency->rate / $fromCurrency->rate;
        }
        return (int)round($result);
    }
}