<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('automations', function (Blueprint $table) {
            $table->foreignId('configuration_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('automations', function (Blueprint $table) {
            $table->foreignId('configuration_id')->nullable(false)->change();
        });
    }
};
