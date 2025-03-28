<?php

namespace Database\Seeders;

use App\Models\RoomBooking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomBookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomBooking = RoomBooking::factory()->count(20)->make();

        RoomBooking::query()->insert($roomBooking->toArray());
    }
}
