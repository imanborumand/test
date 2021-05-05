<?php

namespace Database\Factories;

use App\Models\webservice;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebserviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = webservice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
