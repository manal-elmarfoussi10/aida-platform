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
        Schema::table('sites', function (Blueprint $table) {
            $table->string('city')->nullable()->after('name');
            $table->string('image_url')->nullable()->after('city');
        });
    }
    
    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn(['city', 'image_url']);
        });
    }
};
