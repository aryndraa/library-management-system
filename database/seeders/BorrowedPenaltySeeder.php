<?php

namespace Database\Seeders;

use App\Models\BorrowedBook;
use App\Models\BorrowedPenalty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowedPenaltySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lateReturnCount = BorrowedBook::query()
            ->whereDate('returned_date', '>', 'due_date')
            ->count();

        $borrowedPenalty = BorrowedPenalty::factory()->count(10)->make();

        BorrowedPenalty::query()->insert($borrowedPenalty->toArray());
    }
}
