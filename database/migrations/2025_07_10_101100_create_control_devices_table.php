<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('control_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zone_id'); // d'abord déclarer la colonne
            $table->foreign('zone_id')->references('id')->on('zones_v2')->onDelete('cascade');
            $table->string('type');
            $table->json('settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_devices');
    }
};
