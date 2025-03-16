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
        Schema::create('librarian_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('librarian_id')->constrained('librarians');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('gender')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('librarian_profiles');
    }
};
