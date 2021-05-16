<?php
declare(strict_types=1);

namespace App\Services;

class CurrencyPropertiesService
{
    public function name(string $symbol): string
    {
        $name = [
            'EUR' => 'Eiro',
            'AUD' => 'Austrālijas dolārs',
            'BGN' => 'Bulgārijas leva',
            'BRL' => 'Brazīlijas reāls',
            'CAD' => 'Kanādas dolārs',
            'CHF' => 'Šveices franks',
            'CNY' => 'Ķīnas juaņa renminbi',
            'CZK' => 'Čehijas krona',
            'DKK' => 'Dānijas krona',
            'GBP' => 'Lielbritānijas sterliņu mārciņa',
            'HKD' => 'Hongkongas dolārs',
            'HRK' => 'Horvātijas kuna',
            'HUF' => 'Ungārijas forints',
            'IDR' => 'Indonēzijas rūpija',
            'ILS' => 'Izraēlas šekelis',
            'INR' => 'Indijas rūpija',
            'ISK' => 'Islandes krona',
            'JPY' => 'Japānas jena',
            'KRW' => 'Dienvidkorejas vona',
            'MXN' => 'Meksikas peso',
            'MYR' => 'Malaizijas ringits',
            'NOK' => 'Norvēģijas krona',
            'NZD' => 'Jaunzēlandes dolārs',
            'PHP' => 'Filipīnu peso',
            'PLN' => 'Polijas zlots',
            'RON' => 'Rumānijas leja',
            'RUB' => 'Krievijas rublis',
            'SEK' => 'Zviedrijas krona',
            'SGD' => 'Singapūras dolārs',
            'THB' => 'Taizemes bats',
            'TRY' => 'Turcijas lira',
            'USD' => 'ASV dolārs',
            'ZAR' => 'Dienvidāfrikas rends',
        ];
        return $name[$symbol];
    }

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