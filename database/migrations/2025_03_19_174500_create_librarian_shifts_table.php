<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('librarian_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('librarian_id')->constrained('librarians');
            $table->string('day');
            $table->time('clock_in');
            $table->time('clock_out');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('librarian_shifts');
    }
};
