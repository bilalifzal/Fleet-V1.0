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
        Schema::create('ledger_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tx_hash')->unique(); // Blockchain-style transaction hash
            $table->string('truck_unit'); // e.g., TRK-990
            $table->string('type'); // 'REVENUE' or 'EXPENSE'
            $table->string('description'); // e.g., 'DELIVERY PAY' or 'FUEL EXPENSE'
            $table->decimal('amount', 12, 2); // Handles up to billions!
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_transactions');
    }
};
