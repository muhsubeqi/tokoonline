<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subtotal = ['20000', '100000', '50000'];
        $ekspedisi = ['jne', 'pos', 'tiki'];
        $status = ['0', '1', '2', '3'];
        return [
            'code' => 'INV-' . date('ymdhis') . auth()->user()->id,
            'users_id' => 2,
            'products_id' => Str::random(9),
            'qty' => 5,
            'subtotal' => 5 * $this->faker->randomElement($subtotal),
            'cities_id' => Str::random(500),
            'ekspedisi' => $this->faker->randomElement($ekspedisi),
            'status' => $this->faker->randomElement($status),
        ];
    }
}