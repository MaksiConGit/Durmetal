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
        Schema::create('nota_credito_venta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdFacturaVenta')->nullable()->constrained('factura_venta')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
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
            $table->foreignId('IdCondicionIva')->nullable()->constrained('condicion_iva')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->string('TipoDocumentoCliente');
            $table->string('NumeroDocumentoCliente');
            $table->string('Direccion');
            $table->string('Localidad');
            $table->float('Neto');
            $table->float('NetoNoGravado');
            $table->float('IVA');
            $table->float('Exento');
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
        Schema::dropIfExists('nota_credito_venta');
    }
};
