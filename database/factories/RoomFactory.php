<?php

namespace Database\Factories;

use App\Models\Library;
use App\Models\RoomCategory;
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
            "library_id"       => Library::query()->inRandomOrder()->first()->id,
            "room_category_id" => RoomCategory::query()->inRandomOrder()->first()->id,
            "name"             => fake()->name(),
            "status"           => fake()->randomElement(['available', 'maintenance', 'booked']),
            "price"            => fake()->numberBetween(35000, 80000),
        ];
//        randomElement(['creative', 'lounge', 'conference', 'study'])
    }
}
