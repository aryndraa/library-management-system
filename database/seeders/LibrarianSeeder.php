<?php

namespace Database\Seeders;

use App\Models\Librarian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $librarians = Librarian::factory()->count(1000)->make();
        Librarian::query()->insert($librarians->toArray());
    }
}
