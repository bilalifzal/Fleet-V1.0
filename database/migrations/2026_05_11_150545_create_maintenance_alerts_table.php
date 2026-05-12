<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up(): void
    {
        Schema::create('maintenance_alerts', function (Blueprint $table) {
            $table->id();
            // Connects the alert strictly to a specific Truck
            $table->foreignId('truck_id')->constrained('trucks')->onDelete('cascade');
            
            $table->string('component'); // e.g., Transmission, Brakes, Engine Oil
            $table->integer('wear_percentage'); // e.g., 82%
            $table->integer('days_to_failure'); // AI prediction of when it breaks
            $table->string('severity'); // URGENT, WARNING, or OPTIMAL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_alerts');
    }
};
