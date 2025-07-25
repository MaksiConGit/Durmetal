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
        Schema::create('nota_envio', function (Blueprint $table) {
            $table->id();
            $table->string('Letra');
            $table->integer('PuntoVenta');
            $table->integer('Numero');
            $table->string('NumeroCompleto');
            $table->date('FechaEmision');
            $table->date('FechaVencimiento');
            $table->boolean('AfectarPlanillaTurno');
            $table->string('CondicionPrecios');
            $table->foreignId('IdCliente')->nullable()->constrained('cliente')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->string('RazonSocial');
            $table->foreignId('IdCondicionIva')->nullable()->constrained('condicion_iva')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->string('TipoDocumento');
            $table->string('NumeroDocumentoCliente');
            $table->string('Direccion');
            $table->string('Localidad');
            $table->string('Provincia');
            $table->string('Estado');
            $table->string('TipoOperacion')->nullable();
            $table->float('PorcentajeDescuento');
            $table->float('Neto');
            $table->float('IVA');
            $table->float('Total');
            $table->string('Observaciones');
            $table->integer('NumeroTurno');
            $table->integer('ReferenciaTurno');
            $table->float('AjusteCtaCtePlanillaTurno');
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->nullable()->constrained('users')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->nullable()->constrained('users')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->boolean('Activo');
            $table->string('PuntoVentaNumero');
            $table->integer('CantidadImpresiones');
            $table->integer('CantidadEnviosPorCorreo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_envio');
    }
};
