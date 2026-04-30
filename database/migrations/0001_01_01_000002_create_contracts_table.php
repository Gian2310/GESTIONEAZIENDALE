<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('daily_hours')->default(8); // Ore giornaliere standard
            $table->integer('pause_minutes')->default(30); // Pausa pranzo in minuti
            $table->integer('vacation_days_per_year')->default(26); // Giorni ferie standard
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
