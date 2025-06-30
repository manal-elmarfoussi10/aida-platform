<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            // Supprimer la colonne 'zone' actuelle
            $table->dropColumn('zone');

            // Ajouter la relation vers la table zones
            $table->unsignedBigInteger('zone_id')->nullable()->after('id');
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropForeign(['zone_id']);
            $table->dropColumn('zone_id');

            $table->string('zone')->nullable(); // remettre si rollback
        });
    }
};
