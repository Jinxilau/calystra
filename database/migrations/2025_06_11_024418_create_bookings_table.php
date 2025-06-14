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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // $table->string('booking_number')->unique();
            $table->foreignId('user_id')->constrained(); // client
            // $table->foreignId('service_id')->constrained();
            // $table->foreignId('photographer_id')->nullable()->constrained('users');

            // Event Details
            $table->string('event_type'); // e.g., wedding, corporate, etc.
            $table->date('event_date');
            $table->time('start_time');
            $table->text('event_location')->nullable();
            $table->string('event_name')->nullable(); // Optional name for the event
            $table->integer('guest_count')->nullable();

            // Pricing
            // $table->decimal('service_price', 10, 2);
            // $table->decimal('addons_total', 10, 2)->default(0);
            // $table->decimal('total_amount', 10, 2);

            // Status
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->enum('deposit_status', ['pending', 'partial', 'paid', 'refunded'])->default('pending');

            $table->text('notes')->nullable(); // special requests or notes

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
