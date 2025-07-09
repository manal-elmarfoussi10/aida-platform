<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('network_devices', function (Blueprint $table) {
        $table->id();
        $table->string('device_name');
        $table->string('type');
        $table->string('serial_number');
        $table->string('mac_address')->unique();
        $table->string('ip_address');
        $table->string('firmware_version');
        $table->boolean('online_status')->default(false);
        $table->boolean('enabled')->default(false);
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('network_devices');
    }
};
