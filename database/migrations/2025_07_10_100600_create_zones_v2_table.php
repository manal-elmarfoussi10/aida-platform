<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('zones_v2', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Zone A, Zone B, etc.
            $table->string('zone_type'); // HVAC, Lighting, etc.
            $table->boolean('status')->default(false); // ON/OFF
            $table->integer('occupancy')->nullable();
            $table->string('temperature_humidity')->nullable(); // 20C, etc.
            $table->string('energy_usage')->nullable(); // 120kWh
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zones_v2');
    }
};
