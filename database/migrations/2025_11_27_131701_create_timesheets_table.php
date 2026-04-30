<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('timesheets', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->dateTime('clock_in'); // Ingresso
      $table->dateTime('clock_out')->nullable(); // Uscita
      $table->float('hours_worked')->nullable(); // Ore lavorate calcolate
      $table->text('notes')->nullable();
      $table->string('exception_type')->nullable(); // 'ritardo', 'straordinario'
      $table->float('overtime_hours')->default(0.00); // Ore straordinario
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('timesheets');
  }
};
