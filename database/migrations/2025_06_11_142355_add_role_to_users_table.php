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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user'); // 'user' or 'admin'
            $table->string('name')->nullable(); // Optional phone number
            $table->string('phone')->nullable(); // Optional phone number
            $table->boolean('is_active')->default(true); // Active status
            $table->string('profile_picture')->nullable(); // Optional profile picture
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        });
    }
};
