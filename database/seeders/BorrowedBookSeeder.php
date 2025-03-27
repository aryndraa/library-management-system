<?php

namespace Database\Seeders;

use App\Models\BorrowedBook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowedBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $borrowedBooks = BorrowedBook::factory()->count(100)->make();

        BorrowedBook::query()->insert($borrowedBooks->toArray());
    }
}
