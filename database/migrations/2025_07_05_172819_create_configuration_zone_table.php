<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('configuration_zone', function (Blueprint $table) {
            $table->unsignedBigInteger('configuration_id');
            $table->unsignedBigInteger('zone_id');

            // Foreign keys
            $table->foreign('configuration_id')
                ->references('id')
                ->on('configurations')
                ->onDelete('cascade');

            $table->foreign('zone_id')
                ->references('id')
                ->on('zones_v2') // ✅ IMPORTANT: correct table name
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('configuration_zone');
    }
};
