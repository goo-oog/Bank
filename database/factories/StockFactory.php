<?php

namespace Database\Factories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => 1,
            'symbol' => 'TSLA',
            'amount' => $this->faker->randomFloat(4, 1, 100),
            'buy_price' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
