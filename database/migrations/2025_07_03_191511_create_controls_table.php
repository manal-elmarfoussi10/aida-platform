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
        Schema::create('controls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('zone_id')->constrained('zones_v2')->onDelete('cascade');
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');

            $table->string('control_type'); // e.g., 'thermostat', 'dimmer', 'rgb_color'
            $table->string('value');        // e.g., '22°C', '63%', '#ffcc00', '46%'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controls');
    }
};
