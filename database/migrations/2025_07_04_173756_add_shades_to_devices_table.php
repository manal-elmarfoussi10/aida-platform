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
            $table->integer('shades')->default(50)->after('rgb_color'); // adjust position if needed
        });
    }
    
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('shades');
        });
    }
};
