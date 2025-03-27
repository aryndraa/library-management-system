<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Library;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "category_id"      => Category::query()->inRandomOrder()->first()->id,
            "library_id"       => Library::query()->inRandomOrder()->first()->id,
            "title"            => fake()->title(),
            "isbn"             => fake()->currencyCode(),
            "author"           => fake()->name(),
            "publisher"        => fake()->company(),
            "pages"            => fake()->numberBetween(50,200),
            "publication_date" => fake()->date(),
            "stock"            =>fake()->numberBetween(1, 10)
        ];
    }
}
