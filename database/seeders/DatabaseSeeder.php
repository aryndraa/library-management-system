<?php

namespace Database\Seeders;

use App\Models\BookComment;
use App\Models\BookReplyComment;
use App\Models\BorrowedPenalty;
use App\Models\LibrarianAbsent;
use App\Models\MemberVisit;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            LibrarySeeder::class,
            LibrarianSeeder::class,
            LibrarianProfileSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
            MemberSeeder::class,
            MemberProfileSeeder::class,
            BorrowedBookSeeder::class,
            BorrowedPenaltySeeder::class,
            BookCommentSeeder::class,
            BookReplyCommentSeeder::class,
            RoomCategorySeeder::class,
            RoomSeeder::class,
            RoomFacilitySeeder::class,
            RoomBookingSeeder::class,
            LibrarianShiftSeeder::class,
            LibrarianAbsentSeeder::class,
            MemberVisitSeeder::class,
        ]);
    }
}
