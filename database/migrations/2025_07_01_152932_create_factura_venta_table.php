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
        Schema::create('factura_venta', function (Blueprint $table) {
            $table->id();
            $table->string('Letra');
            $table->integer('PuntoVenta');
            $table->integer('Numero');
            $table->string('NumeroCompleto');
            $table->date('FechaEmision');
            $table->date('FechaVencimiento');
            $table->date('FechaEstadisticas');
            $table->string('TipoOperacion')->nullable();
            $table->string('CondicionPrecios');
            $table->foreignId('IdCliente')->nullable()->constrained('cliente')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->string('RazonSocial');
            $table->string('TipoDocumentoCliente');
            $table->string('NumeroDocumentoCliente');
            $table->string('Direccion');
            $table->string('Localidad');
            $table->foreignId('IdCondicionIva')->nullable()->constrained('condicion_iva')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->string('CondicionVenta');
            $table->float('Neto');
            $table->float('NetoNoGravado');
            $table->float('Exento');
            $table->float('IVA');
            $table->float('ImpuestoInterno');
            $table->float('Total');
            $table->float('AjusteCtaCtePlanillaTurno');
            $table->string('Estado');
            $table->string('CAE');
            $table->date('FechaVencimientoCAE');
            $table->integer('IdSolicitudCAE');
            $table->string('Observaciones')->nullable();
            $table->integer('NumeroTurno');
            $table->integer('ReferenciaTurno');
            $table->boolean('AfectarPlanillaTurno');
            $table->boolean('EsNotaDeDebito');
            $table->string('NroFacturaNotaDebito')->nullable();
            $table->boolean('EntregarMercaderiaConRemitos');
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->nullable()->constrained('users')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->nullable()->constrained('users')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->boolean('Activo');
            $table->integer('CantidadImpresiones');
            $table->integer('CantidadEnviosPorCorreo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_venta');
    }
};
