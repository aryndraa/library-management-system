<?php

namespace Database\Seeders;

use App\Models\Librarian;
use App\Models\LibrarianProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarianProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $librarianCount = Librarian::query()->count();
        $librarianProfiles = LIbrarianProfile::factory()->count($librarianCount)->make();

        LibrarianProfile::query()->insert($librarianProfiles->toArray());
    }
}
