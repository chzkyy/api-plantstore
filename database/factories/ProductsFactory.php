<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->word(),
            'product_images' => $this->faker->imageUrl(),
            // format rupiah
            'product_price' => $this->faker->numberBetween(1000, 100000),
            'product_description' => $this->faker->sentence(),
            'product_category' => $this->faker->randomElement(['Tanaman Hias', 'Tanaman Obat', 'Tanaman Buah', 'Tanaman Bunga', 'Tanaman Sayur', 'Tanaman Air', 'Tanaman Gantung', 'Tanaman Mini', 'Tanaman Bonsai', 'Tanaman Lainnya']),
        ];
    }
}
