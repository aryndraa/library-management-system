<?php

namespace Database\Factories;

use App\Models\BookComment;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookReplyComment>
 */
class BookReplyCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "member_id"       => Member::query()->inRandomOrder()->first()->id,
            "book_comment_id" => BookComment::query()->inRandomOrder()->first()->id,
            "message"         => $this->faker->realText(),
        ];
    }
}
