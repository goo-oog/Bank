<?php
declare(strict_types=1);

namespace App\Services;

class CurrencyPropertiesService
{
    public function flag(string $symbol): string
    {
        $flag = [
            'EUR' => '🇪🇺',
            'AUD' => '🇦🇺',
            'BGN' => '🇧🇬',
            'BRL' => '🇧🇷',
            'CAD' => '🇨🇦',
            'CHF' => '🇨🇭',
            'CNY' => '🇨🇳',
            'CZK' => '🇨🇿',
            'DKK' => '🇩🇰',
            'GBP' => '🇬🇧',
            'HKD' => '🇭🇰',
            'HRK' => '🇭🇷',
            'HUF' => '🇭🇺',
            'IDR' => '🇮🇩',
            'ILS' => '🇮🇱',
            'INR' => '🇮🇳',
            'ISK' => '🇮🇸',
            'JPY' => '🇯🇵',
            'KRW' => '🇰🇷',
            'MXN' => '🇲🇽',
            'MYR' => '🇲🇾',
            'NOK' => '🇳🇴',
            'NZD' => '🇳🇿',
            'PHP' => '🇵🇭',
            'PLN' => '🇵🇱',
            'RON' => '🇷🇴',
            'RUB' => '🇷🇺',
            'SEK' => '🇸🇪',
            'SGD' => '🇸🇬',
            'THB' => '🇹🇭',
            'TRY' => '🇹🇷',
            'USD' => '🇺🇸',
            'ZAR' => '🇿🇦',
        ];
        return $flag[$symbol];
    }
}