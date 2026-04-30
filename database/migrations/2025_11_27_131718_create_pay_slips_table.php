<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pay_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('pay_date');
            $table->decimal('base_salary', 10, 2);
            $table->float('total_hours_worked');
            $table->float('total_overtime_hours');
            $table->decimal('overtime_pay', 10, 2);
            $table->decimal('bonus_amount', 10, 2)->default(0.00);
            $table->decimal('total_deductions', 10, 2)->default(0.00);
            $table->decimal('net_pay', 10, 2);
            $table->string('file_path')->nullable(); // Simula il path del PDF/Cedolino
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pay_slips');
    }
};
