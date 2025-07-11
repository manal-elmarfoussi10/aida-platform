<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            if (!Schema::hasColumn('devices', 'temperature')) {
                $table->float('temperature')->default(22.0)->after('last_active');
            }
            if (!Schema::hasColumn('devices', 'dimmer')) {
                $table->integer('dimmer')->default(50)->after('temperature');
            }
            if (!Schema::hasColumn('devices', 'color_temperature')) {
                $table->integer('color_temperature')->default(4700)->after('dimmer');
            }
            if (!Schema::hasColumn('devices', 'rgb_color')) {
                $table->string('rgb_color')->default('#ffffff')->after('color_temperature');
            }
        });
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn(['temperature', 'dimmer', 'color_temperature', 'rgb_color']);
        });
    }
};
