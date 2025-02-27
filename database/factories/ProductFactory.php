<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
final class ProductFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'name'        => fake()->unique()->words(2, true),
			'description' => fake()->paragraph(1),
			'price'       => fake()->randomFloat(1, 20, 30),
			'stock'       => fake()->numberBetween(1, 100),
			'rank'        => fake()->numberBetween(1, 20),
			'image'       => null,
		];
	}
}
