<?php
declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use JsonException;

class FinnhubStockExchangeRepository implements StockExchangeRepository
{
    /**
     * @throws JsonException
     */
    private function query(string $symbol, string $type, int $lifeTime)
    {
        $prefix = env('FINNHUB_PREFIX');
        $token = '&token=' . env('FINNHUB_TOKEN');

        if (Cache::has($symbol . $type)) {
            return Cache::get($symbol . $type);
        }
        $dataFromFinnhub = file_get_contents($prefix . $type . $symbol . $token);
        $query = json_decode($dataFromFinnhub, false, 512, JSON_THROW_ON_ERROR);
        Cache::put($symbol . $type, $query, rand((int)($lifeTime * 0.8), (int)($lifeTime * 1.2)));
        return $query;
    }

    /**
     * @throws JsonException
     */
    public function currentPrice(string $symbol): float
    {
        return $this->query($symbol, 'quote?symbol=', 300)->c;
    }

    /**
     * @throws JsonException
     */
    public function info(string $symbol)
    {
        return $this->query($symbol, 'stock/profile2?symbol=', 3600 * 24 * 7);
    }
}