<?php

namespace Database\Seeders;

use App\Models\RoomFacility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomFacilities = RoomFacility::factory()->count(80)->make();

        RoomFacility::query()->insert($roomFacilities->toArray());
    }
}
