<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subtotal = [20000, 100000, 50000];
        $ekspedisi = json_decode('{"code":"pos","name":"POS Indonesia (POS)","value":77000,"etd":"7 HARI"}');
        $status = ['0', '1', '2', '3'];
        $product = [1, 2, 3, 4, 5, 6, 9];
        $city = [1, 2, 3, 4, 5, 6, 9, 10, 17, 200, 300];
        $user = [2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];
        return [
            'code' => 'INV-' . Str::random(2) . auth()->user()->id,
            'users_id' => $this->faker->randomElement($user),
            'products_id' => $this->faker->randomElement($product),
            'qty' => 5,
            'subtotal' => 5 * $this->faker->randomElement($subtotal),
            'cities_id' => $this->faker->randomElement($city),
            'ekspedisi' => $ekspedisi,
            'status' => $this->faker->randomElement($status),
        ];
    }
}