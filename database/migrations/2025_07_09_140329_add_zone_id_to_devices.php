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
            if (!Schema::hasColumn('devices', 'zonev2_id')) {
                $table->foreignId('zonev2_id')
                    ->nullable()
                    ->constrained('zones_v2')
                    ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropForeign(['zonev2_id']);
            $table->dropColumn('zonev2_id');
        });
    }
};
