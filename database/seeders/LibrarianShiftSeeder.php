<?php

namespace Database\Seeders;

use App\Models\LibrarianShift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarianShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $librarianShifts = LibrarianShift::factory()->count(50)->make();

        LibrarianShift::query()->insert($librarianShifts->toArray());
    }
}
