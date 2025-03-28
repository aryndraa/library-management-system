<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BorrowedBook>
 */
class BorrowedBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $book =  Book::query()->inRandomOrder()->first();
        $bookLibrary = $book->library()->pluck('id');
        $borrowedDate = fake()->dateTimeThisYear();
        $dueDate = (clone $borrowedDate)->modify('+5 days');
        $returnedDate = (clone $dueDate)->modify('+' . rand(1, 10) . ' days');

        return [
            "book_id"       => $book->id,
            "member_id"     => Member::query()->inRandomOrder()->first()->id,
            "library_id"    => $bookLibrary,
            "borrowed_date" => $borrowedDate,
            "due_date"      => $dueDate,
            "returned_date" => $returnedDate,
            "code"          => fake()->currencyCode()
        ];
    }
}
