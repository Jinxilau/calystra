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

            // Client Information
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // client
            // Event Details
            $table->string('event_type'); // e.g., wedding, corporate, etc.
            $table->date('event_date');
            $table->time('start_time');
            $table->text('event_location')->nullable();
            $table->string('event_name')->nullable(); // Optional name for the event
            $table->integer('guest_count')->nullable();
            // Status
            $table->enum('status', ['approved', 'pending', 'denied'])->default('pending');
            // Photographer Assignment
            $table->text('notes')->nullable(); // special requests or notes
            
            $table->timestamps();
            
            // $table->foreignId('photographer_id')->nullable()->constrained('photographers')->onDelete('set null'); // Many to many so dont need this 
            // $table->enum('deposit_status', ['pending', 'partial', 'paid', 'refunded'])->default('pending');
            // Pricing
            // $table->decimal('service_price', 10, 2);
            // $table->decimal('addons_total', 10, 2)->default(0);
            // $table->decimal('total_amount', 10, 2);
            // $table->foreignId('service_id')->constrained();
            // $table->string('booking_number')->unique();
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
