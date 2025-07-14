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
       Schema::create('nodes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('automation_id')->constrained()->onDelete('cascade');
    $table->string('type'); // 'trigger', 'condition', 'action'
    $table->json('data');   // {"label": "Motion detected"}
    $table->integer('x')->default(100);
    $table->integer('y')->default(100);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nodes');
    }
};
