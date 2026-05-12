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
        // This safely adds the location column right after the cost column
        Schema::table('fuel_logs', function (Blueprint $table) {
            $table->string('location')->after('cost')->nullable(); 
        });
    }

    public function down(): void
    {
        // This removes it if we ever need to undo the patch
        Schema::table('fuel_logs', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
};
