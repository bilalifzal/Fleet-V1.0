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
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('unit_number')->unique(); // e.g., TRK-990
            $table->string('vin')->unique(); // Vehicle Identification Number
            $table->string('status')->default('En Route'); // En Route, Offline, Loading
            $table->integer('current_speed')->default(0);
            $table->decimal('latitude', 10, 7)->nullable(); // For the Live Map
            $table->decimal('longitude', 10, 7)->nullable(); // For the Live Map
            $table->integer('ai_health_score')->default(100); // For predictive maintenance
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
