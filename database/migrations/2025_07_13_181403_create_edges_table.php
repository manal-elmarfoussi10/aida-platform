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
        Schema::create('edges', function (Blueprint $table) {
    $table->id();
    $table->foreignId('automation_id')->constrained()->onDelete('cascade');
    $table->foreignId('source_node_id')->constrained('nodes')->onDelete('cascade');
    $table->foreignId('target_node_id')->constrained('nodes')->onDelete('cascade');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edges');
    }
};
