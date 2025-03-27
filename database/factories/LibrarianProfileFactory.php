<?php

namespace Database\Factories;

use App\Models\Librarian;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LibrarianProfile>
 */
class LibrarianProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "librarian_id" => Librarian::query()->inRandomOrder()->first()->id,
            "first_name"   => fake()->firstName(),
            "last_name"    => fake()->lastName(),
            "phone"        => fake()->phoneNumber(),
            "gender"       => fake()->randomElement(["male", "female"]),
            "birth_date"   => fake()->date(),
            "province"     => fake()->country(),
            "city"         => fake()->city(),
            "address"      => fake()->address(),

        ];
    }
}
