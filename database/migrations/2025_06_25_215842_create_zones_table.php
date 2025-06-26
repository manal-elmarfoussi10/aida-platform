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
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('comfort_status')->nullable(); // e.g. Too Hot, Just Right
            $table->string('energy_usage')->nullable();   // e.g. 1.2 kWh
            $table->string('device_type')->nullable();    // Light, HVAC, Shade
            $table->boolean('maintenance_alert')->default(false);
            $table->boolean('device_control_status')->default(false); // ON/OFF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
