<?php

namespace Database\Seeders;

use App\Models\BookReplyComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookReplyCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookReplyComments = BookReplyComment::factory()->count(100)->make();

        BookReplyComment::query()->insert($bookReplyComments->toArray());
    }
}
