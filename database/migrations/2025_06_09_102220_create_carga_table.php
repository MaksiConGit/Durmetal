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
        Schema::create('carga', function (Blueprint $table) {
            $table->id();
            $table->integer('Numero');
            $table->string('Referencia');
            $table->date('FechaCarga');
            $table->string('HoraCarga')->nullable();
            $table->date('FechaDescarga');
            $table->string('HoraDescarga')->nullable();
            $table->integer('TiempoProceso');
            $table->integer('TemperaturaProceso');
            $table->foreignId('IdMedioEnfriamiento')->constrained('medio_enfriamiento')
                                                    ->onDelete('restrict')
                                                    ->onUpdate('cascade');
            $table->foreignId('EjecutadoPorOperador')->constrained('users')
                                                    ->onDelete('restrict')
                                                    ->onUpdate('cascade');
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->nullable()->constrained('users')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->nullable()->constrained('users')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->boolean('Activo')->nullable();
            $table->string('NumeroReferencia');
            $table->integer('NumeroHorno');
            $table->string('FechaCargaFechaDescargaNumeroHorno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carga');
    }
};
