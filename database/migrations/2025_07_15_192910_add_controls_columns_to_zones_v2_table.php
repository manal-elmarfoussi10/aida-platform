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
        Schema::table('zones_v2', function (Blueprint $table) {
            $table->integer('shades')->nullable()->after('temperature_humidity');
            $table->integer('dimmer')->nullable()->after('shades');
            $table->integer('color_temperature')->nullable()->after('dimmer');
            $table->string('rgb_color')->nullable()->after('color_temperature');
        });
    }

    public function down(): void
    {
        Schema::table('zones_v2', function (Blueprint $table) {
            $table->dropColumn(['shades', 'dimmer', 'color_temperature', 'rgb_color']);
        });
    }
};
