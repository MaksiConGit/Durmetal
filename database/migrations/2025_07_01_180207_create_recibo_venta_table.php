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
        Schema::create('recibo_venta', function (Blueprint $table) {
            $table->id();
            $table->string('Letra');
            $table->integer('PuntoVenta');
            $table->integer('Numero');
            $table->string('NumeroCompleto');
            $table->date('FechaEmision');
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
            $table->float('RetencionDREI');
            $table->float('RetencionIIBB');
            $table->float('RetencionIVA');
            $table->float('RetencionGanancias');
            $table->float('RetencionSUSS');
            $table->string('Estado');
            $table->float('Total');
            $table->string('Observaciones')->nullable();
            $table->integer('NumeroTurno');
            $table->integer('ReferenciaTurno');
            $table->integer('IdEntorno')->default(1);
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
            $table->string('LetraNumeroCompleto');
            $table->integer('CantidadImpresiones');
            $table->integer('CantidadEnviosPorCorreo');
            $table->string('DescripcionSaldoTransportado')->nullable();
            $table->float('ImporteSaldoTransportado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibo_venta');
    }
};
