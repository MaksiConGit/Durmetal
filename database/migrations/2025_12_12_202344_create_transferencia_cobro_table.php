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
        Schema::create('transferencia_cobro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdCobro')->nullable()->constrained('cobro')
                                                    ->onDelete('restrict')
                                                    ->onUpdate('cascade');
            $table->foreignId('IdBanco')->nullable()->constrained('banco')
                                                    ->onDelete('restrict')
                                                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferencia_cobro');
    }
};
