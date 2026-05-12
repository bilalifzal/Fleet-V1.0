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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('employee_id')->unique(); // e.g., DRV-001
            $table->string('license_class'); // e.g., Class-A
            $table->integer('fatigue_level')->default(0); // 0 to 100
            $table->integer('safety_score')->default(100); // 0 to 100
            $table->string('status')->default('RESTING'); // DRIVING, RESTING, OFF-DUTY
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
