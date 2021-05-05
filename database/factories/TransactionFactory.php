<?php

namespace Database\Factories;

use App\Models\transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'amount' => $this->faker->numberBetween(10000, 200000),
            'type' => TRANSACTION_TYPES[rand(0, 2)]
        ];
    }
}
