<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookComment>
 */
class BookCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "member_id" => Member::query()->inRandomOrder()->first()->id,
            "book_id"   => Book::query()->inRandomOrder()->first()->id,
            "message"   => fake()->text(80)
        ];
    }
}
