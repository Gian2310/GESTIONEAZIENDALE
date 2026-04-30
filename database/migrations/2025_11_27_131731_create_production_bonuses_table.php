<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_bonuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('bonus_date');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null'); // Per bonus di reparto
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_bonuses');
    }
};
