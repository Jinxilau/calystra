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
        Schema::create('photographer_availabilities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('photographer_id')->constrained('photographers')->onDelete('cascade');
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            // $table->boolean('is_available')->default(true); // Optional if want to track availability status
            $table->string('reason'); 
            
            $table->timestamps();

            $table->unique(['photographer_id', 'date', 'start_time'], 'photographer_unique_slot'); // Ensure unique availability per photographer per time slot
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photographer_availabilities');
    }
};


/* 
No need to pre-fill every available slot.

Only unavailability are stored.

Photographers block time when busy (just like a calendar).

Default = available.

Easier Bookings:

The system only checks for conflicts (unavailable slots).

No need to scan both "available" and "unavailable" entries.

Clear Reasons:

Every blocked slot has a reason (helpful for reporting/rescheduling).*/