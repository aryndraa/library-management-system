<?php

namespace Database\Factories;

use App\Models\BorrowedBook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BorrowedPenalty>
 */
class BorrowedPenaltyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
//        $borrowedBook = BorrowedBook::query()
//            ->where('id', 1 )
//            ->first();

//        if (!$borrowedBook) {
//            return [];
//        }

//        $dueDate = (clone $borrowedBook->returned_date)->modify('+5 days');

        return [
            "borrowed_book_id" => BorrowedBook::query()->inRandomOrder()->first()->id,
            "penalty" => fake()->sentence(),
            "message" => fake()->text(),
            "charge"  => fake()->numberBetween(10000, 20000),
            "due"     => fake()->date(),
        ];
    }
}
