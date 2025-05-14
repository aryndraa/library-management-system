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
        Schema::table('member_profiles', function (Blueprint $table) {
            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->date('birthday')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('province')->nullable()->change();
            $table->string('city')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_profiles', function (Blueprint $table) {
            $table->string('first_name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
            $table->date('birthday')->nullable(false)->change();
            $table->string('gender')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('province')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
        });
    }
};
