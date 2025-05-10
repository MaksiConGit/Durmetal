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
        Schema::create('orden_trabajo', function (Blueprint $table) {
            $table->id();
            $table->string('Letra');
            $table->integer('PuntoVenta');
            $table->integer('Numero');
            $table->string('NumeroCompleto');
            $table->integer('NumeroRemitoCliente');
            $table->date('FechaEmision');
            $table->date('FechaVencimiento')->nullable();
            $table->boolean('AfectarPlanillaTurno');
            $table->string('CondicionPrecios');
            $table->foreignId('IdCliente')->constrained('cliente')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->string('RazonSocial');
            $table->foreignId('IdCondicionIva')->constrained('condicion_iva')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->string('TipoDocumentoCliente');
            $table->string('NumeroDocumentoCliente', 20);
            $table->string('Direccion');
            $table->string('Localidad');
            $table->string('Provincia');
            $table->string('Estado');
            $table->float('Total');
            $table->string('Observaciones')->nullable();
            $table->integer('NumeroTurno');
            $table->integer('ReferenciaTurno');
            $table->float('AjusteCtaCtePlanillaTurno');
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->constrained('users')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->constrained('users')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->boolean('Activo');
            $table->float('PuntoVentaNumero');
            $table->string('IdClienteEstado');
            $table->string('IdClienteFechaEmisionPuntoVentaNumero');
            $table->integer('CantidadImpresiones');
            $table->integer('CantidadEnviosPorCorreo');
            $table->boolean('Archivado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_trabajo');
    }
};
