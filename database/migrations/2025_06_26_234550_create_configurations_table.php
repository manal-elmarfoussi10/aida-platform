<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
{
    Schema::create('configurations', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('type');
    $table->json('zones')->nullable(); // Stocke des zones comme tableau JSON
    $table->string('mode')->nullable(); // Ex: Eco, Standard, Performance
    $table->timestamps();
});

}





    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
