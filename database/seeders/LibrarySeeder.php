<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Library;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Library::factory()->count(50)->make();
        Library::query()->insert($books->toArray());
    }
}
