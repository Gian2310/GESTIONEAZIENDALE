<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // 'Ferie', 'Permesso', 'Malattia'
            $table->date('start_date');
            $table->date('end_date');
            $table->float('days_requested')->default(0);
            $table->string('status')->default('Pending'); // 'Pending', 'Approved', 'Rejected'
            $table->text('reason')->nullable();
            $table->text('manager_notes')->nullable();
            $table->string('certificate_path')->nullable(); // Per certificati medici
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
