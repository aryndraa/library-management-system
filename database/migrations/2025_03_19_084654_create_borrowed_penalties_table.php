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
        Schema::create('borrowed_penalties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowed_book_id')->constrained('borrowed_books')->onDelete('cascade');
            $table->string('penalty');
            $table->text('message');
            $table->integer('charge');
            $table->date('due');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowed_penalties');
    }
};
