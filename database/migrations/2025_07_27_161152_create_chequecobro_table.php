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
        Schema::create('chequecobro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdCobro')->nullable()->constrained('cobro')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade'); 
            $table->date('FechaEmision');
            $table->date('FechaAcreditacion');
            $table->foreignId('IdBanco')->nullable()->constrained('banco')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade'); 
            $table->integer('Numero');
            $table->foreignId('IdDestinoCheque')->nullable()->constrained('destino_cheque')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade'); 
            $table->integer('Plaza')->nullable();
            $table->boolean('eCheck');
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->nullable()->constrained('users')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->nullable()->constrained('users')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->boolean('Activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chequecobro');
    }
};
