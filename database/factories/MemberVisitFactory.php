<?php

namespace Database\Factories;

use App\Models\Library;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberVisit>
 */
class MemberVisitFactory extends Factory
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
            "library_id" => Library::query()->inRandomOrder()->first()->id,
        ];
    }
}
