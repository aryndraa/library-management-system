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
        $librarianShift = LibrarianShift::query()->inRandomOrder()->first();

        $dayMap = [
            'Sunday' => 0, 'Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3,
            'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6,
        ];

        $shiftDay = $librarianShift->day;
        $daysToAdd = $dayMap[$shiftDay] - now()->dayOfWeek;
        $createdAtDate = now()->startOfWeek()->addDays($daysToAdd)->format('Y-m-d');

        $createdAt = Carbon::createFromFormat('Y-m-d H:i:s', "$createdAtDate {$librarianShift->clock_in}");

        return [
            "librarian_id" => Librarian::query()->inRandomOrder()->first()->id,
            "status" => fake()->randomElement(['presence', 'absent']),
            "created_at" => $createdAt,
        ];
    }
}
