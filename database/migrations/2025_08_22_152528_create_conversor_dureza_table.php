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
        Schema::create('conversor_dureza', function (Blueprint $table) {
            $table->id();
            $table->integer('ValorHB');
            $table->integer('ValorHRC');
            $table->integer('ValorKMM2');
            $table->integer('ValorMPA');
            $table->integer('ValorKSI');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversor_dureza');
    }
};
