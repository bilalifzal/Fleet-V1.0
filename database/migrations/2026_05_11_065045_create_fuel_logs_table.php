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
        Schema::create('fuel_logs', function (Blueprint $table) {
            $table->id();
            // This connects the fuel log strictly to a specific truck!
            $table->foreignId('truck_id')->constrained('trucks')->onDelete('cascade');
            
            $table->decimal('liters', 8, 2);
            $table->decimal('cost', 10, 2);
            $table->string('location_node'); // e.g., Lahore Center
            $table->string('blockchain_hash')->unique(); // Ultra-secure receipt
            $table->string('security_status')->default('Verified'); // Verified or Anomalous
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_logs');
    }
};
