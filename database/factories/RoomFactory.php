<?php

namespace Database\Factories;

use App\Models\Library;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "library_id" => Library::query()->inRandomOrder()->first()->id,
            "name" => $this->faker->name(),
            "type" => $this->faker->randomElement(['creative', 'lounge', 'conference', 'study']),
            "status" => fake()->randomElement(['available', 'maintenance', 'booked']),
            "price" => fake()->numberBetween(35000, 80000),
        ];
    }
}
