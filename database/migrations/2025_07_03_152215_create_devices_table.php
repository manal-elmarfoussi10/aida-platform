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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_id')->constrained('zones_v2')->onDelete('cascade');
            $table->string('device_type');
            $table->string('device_name');
            $table->boolean('current_status')->default(0);
            $table->boolean('manual_control')->default(0);
            $table->timestamp('last_active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
