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
       Schema::create('assistants', function (Blueprint $table) {
    $table->id();
    $table->string('name');         // ex: AI Assistant, Humanoid Assistant
    $table->string('type');         // ex: ai, humanoid
    $table->string('status');       // ex: online, offline
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assistants', function (Blueprint $table) {
            //
        });
    }
};
