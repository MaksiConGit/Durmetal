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
        Schema::create('item_orden_trabajo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdOrdenTrabajo')->constrained('orden_trabajo')
                                                    ->onDelete('restrict')
                                                    ->onUpdate('cascade');
            $table->foreignId('IdMaterial')->constrained('material')
                                                    ->onDelete('restrict')
                                                    ->onUpdate('cascade');
            $table->foreignId('IdTratamiento')->constrained('tratamiento')
                                                    ->onDelete('restrict')
                                                    ->onUpdate('cascade');
            $table->foreignId('IdDureza')->constrained('dureza')
                                        ->onDelete('restrict')
                                        ->onUpdate('cascade');
            $table->integer('ItemNumero');
            $table->string('Descripcion');
            $table->integer('NroDeposito');
            $table->float('Cantidad');
            $table->float('Peso');
            $table->integer('CodigoComplejidad');
            $table->float('Coeficiente');
            $table->integer('DurezaSolicitadaMinima');
            $table->integer('DurezaSolicitadaMaxima');
            $table->float('PrecioUnitario');
            $table->float('Total');
            $table->boolean('AfectaPlanillaTurno');
            $table->boolean('ControlarStock');
            $table->string('Estado');
            $table->date('FechaActualizacionEstado')->nullable();
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->constrained('users')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->constrained('users')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->boolean('Activo');
            $table->boolean('CertificadoEmitido');
            $table->integer('CantidadCertificadosImpresos');
            $table->integer('CantidadCertificadosEnviadosPorCorreo');
            $table->string('Observaciones')->nullable();
            $table->integer('CantidadProgramaciones');
            $table->boolean('ConNotaEnvio');
            $table->string('IDEstadoConNotaEnvio');
            $table->string('IDIdOrdenTrabajoIdMaterialIdTratamientoCodigoComplejidadEstado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_orden_trabajo');
    }
};
