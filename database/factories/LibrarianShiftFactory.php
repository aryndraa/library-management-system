<?php

namespace Database\Factories;

use App\Models\Librarian;
use App\Models\LibrarianShift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LibrarianShift>
 */
class LibrarianShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $librarian = Librarian::query()->inRandomOrder()->first();

        do {
            $day = fake()->dayOfWeek();
            $clockIn = fake()->time();
            $clockOut = (clone Carbon::createFromFormat('H:i:s', $clockIn))
                ->addHours(fake()->numberBetween(4, 8)) // Durasi shift antara 4-8 jam
                ->format('H:i:s');

            $exists = LibrarianShift::query()->whereHas('librarian', function ($query) use ($librarian) {
                $query->where('library_id', $librarian->library_id);
            })
                ->where('day', $day)
                ->where(function ($query) use ($clockIn, $clockOut) {
                    $query->whereBetween('clock_in', [$clockIn, $clockOut])
                        ->orWhereBetween('clock_out', [$clockIn, $clockOut]);
                })
                ->exists();
        } while ($exists);

        return [
            "librarian_id" => Librarian::query()->inRandomOrder()->first()->id,
            "day" => fake()->dayOfWeek(),
            "clock_in" => fake()->time(),
            "clock_out" => fake()->time(),
        ];
    }
}
