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

            $table->string('booking_number')->unique();
            $table->foreignId('user_id')->constrained();
            // $table->foreignId('service_id')->nullable()->constrained();
            $table->foreignId('package_id')->nullable()->constrained();
            
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('event_type');
            $table->text('event_location');
            $table->text('special_requirements')->nullable();
            $table->integer('guest_count')->nullable();
            
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 8, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'partial', 'paid', 'refunded'])->default('pending');
            
            $table->text('notes')->nullable();

            $table->timestamps();
            // 8 9
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
