<?php

namespace Database\Seeders;

use App\Models\MemberVisit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberVisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberVisits = MemberVisit::factory()->count(200)->make();

        MemberVisit::query()->insert($memberVisits->toArray());
    }
}
