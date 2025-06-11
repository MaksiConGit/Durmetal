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
        Schema::create('programacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdItemOrdenTrabajo')->constrained('item_orden_trabajo')
                                                    ->onDelete('restrict')
                                                    ->onUpdate('cascade');
            $table->integer('NumeroProgramacion')->nullable();
            $table->integer('DurezaMinima');
            $table->integer('DurezaMaxima');
            $table->foreignId('IdTipoProgramacion')->constrained('tipo_programacion')
                                                    ->onDelete('restrict')
                                                    ->onUpdate('cascade');
            $table->float('Cantidad');
            $table->string('Apto')->nullable();
            $table->boolean('Reproceso');
            $table->date('FechaCreacion')->nullable();
            $table->dateTime('FechaCarga');
            $table->dateTime('FechaDescarga');
            $table->integer('Temperatura');
            $table->foreignId('IdMedioEnfriamiento')->constrained('medio_enfriamiento')
                                                    ->onDelete('restrict')
                                                    ->onUpdate('cascade');
            $table->integer('NumeroHorno');
            $table->foreignId('EjecutadoPorOperador')->constrained('users')
                                                    ->onDelete('restrict')
                                                    ->onUpdate('cascade');
            $table->foreignId('CreadoPor')->constrained('users')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->constrained('users')
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
        Schema::dropIfExists('programacion');
    }
};
