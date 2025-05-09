<?php

namespace Database\Factories;

use App\Models\Librarian;
use App\Models\LibrarianAbsent;
use App\Models\LibrarianShift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LibrarianAbsent>
 */
class LibrarianAbsentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $status = fake()->randomElement(['presence', 'absent']);
        $description = $status === 'absent' ? fake()->sentence(20) : "";

        return [
            "librarian_id" => Librarian::query()->inRandomOrder()->first()->id,
            "status"       => $status,
            "description"  => $description,
        ];
    }
}
