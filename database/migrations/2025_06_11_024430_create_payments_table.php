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

            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_type', ['deposit', 'full_payment', 'remaining_balance']);
            $table->enum('payment_method', ['bank_transfer', 'online_banking', 'cash', 'credit_card']);
            $table->string('receipt_path')->nullable();
            
            $table->enum('status', ['pending_verification', 'verified', 'rejected'])->default('pending_verification');
            $table->text('customer_notes')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
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
