<?php
declare(strict_types=1);

namespace App\Repositories;

interface CurrencyRatesRepository
{
    public function getRates();

    public function getAllSymbols();
}