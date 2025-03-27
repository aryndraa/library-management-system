<?php

namespace Database\Seeders;

use App\Models\BookComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookComment = BookComment::factory()->count(100)->make();

        BookComment::query()->insert($bookComment->toArray());
    }
}
