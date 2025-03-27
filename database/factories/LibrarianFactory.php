<?php

namespace Database\Factories;

use App\Models\Library;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Librarian>
 */
class LibrarianFactory extends Factory
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
            "email"      => fake()->unique()->safeEmail(),
            "password"   => bcrypt('password'),
        ];
    }
}
