<?php

namespace Database\Factories;

use App\Models\Library;
use App\Models\Member;
use Carbon\Carbon;
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
        $timestamp = Carbon::instance(fake()->dateTimeThisYear())->format('Y-m-d H:i:s');
        return [
            "member_id" => Member::query()->inRandomOrder()->first()->id,
            "library_id" => Library::query()->inRandomOrder()->first()->id,
            "visit_date" => $timestamp,
        ];
    }
}
