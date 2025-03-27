<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Library>
 */
class LibraryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name"         => fake()->name(),
            "address"      => fake()->address(),
            "phone"        => fake()->phoneNumber(),
            "email"        => fake()->email(),
            "opening_time" => "08:00:00",
            "closing_time" => "18:00:00",
        ];
    }
}
