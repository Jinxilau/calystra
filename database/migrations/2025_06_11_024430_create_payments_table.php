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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->decimal('amount', 10, 2)->default(200.00);
            $table->string('receipt_path')->nullable();
            
            
            $table->timestamps();
            
            // $table->enum('status', ['pending_verification', 'verified', 'rejected'])->default('pending_verification');
            // $table->text('admin_notes')->nullable();
            // $table->foreignId('reviewed_by')->nullable()->constrained('users');
            // $table->enum('payment_type', ['deposit', 'full_payment', 'remaining_balance']);
            // $table->enum('payment_method', ['bank_transfer', 'online_banking', 'cash', 'credit_card']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
