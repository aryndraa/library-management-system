<?php

namespace Database\Seeders;

use App\Models\LibrarianAbsent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarianAbsentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $librarianAbsent = LibrarianAbsent::factory()->count(50)->make();

        LibrarianAbsent::query()->insert($librarianAbsent->toArray());
    }
}
