<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->text('response');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rules');
    }
};
