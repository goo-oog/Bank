<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => 1,
            'partner_account' => strtoupper(hash('crc32', microtime())),
            'description' => $this->faker->sentence,
            'amount' => $this->faker->numberBetween(-1000000, 1000000),
            'currency' => $this->faker->currencyCode,
            'type' => 'money'
        ];
    }
}
