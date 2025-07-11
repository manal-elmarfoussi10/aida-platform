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
        Schema::table('devices', function (Blueprint $table) {
            $table->float('temperature')->nullable();         // HVAC temp
            $table->integer('dimmer')->nullable();            // Lights dimmer level (0–100)
            $table->integer('color_temperature')->nullable(); // e.g. 2700K–6500K
            $table->string('rgb_color')->nullable();          // e.g. '#ff0000'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            //
        });
    }
};
