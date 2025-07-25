<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orden_trabajo', function (Blueprint $table) {
            $table->id();
            $table->string('Letra')->nullable();
            $table->integer('PuntoVenta');
            $table->integer('Numero');
            $table->string('NumeroCompleto')->nullable();
            $table->integer('NumeroRemitoCliente')->nullable();
            $table->date('FechaEmision')->nullable();
            $table->date('FechaVencimiento')->nullable();
            $table->boolean('AfectarPlanillaTurno')->nullable();
            $table->string('CondicionPrecios')->nullable();
            $table->foreignId('IdCliente')->nullable()->constrained('cliente')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->string('RazonSocial')->nullable();
            $table->foreignId('IdCondicionIva')->nullable()->constrained('condicion_iva')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->string('TipoDocumentoCliente')->nullable();
            $table->string('NumeroDocumentoCliente', 20)->nullable();
            $table->string('Direccion')->nullable();
            $table->string('Localidad')->nullable();
            $table->string('Provincia')->nullable();
            $table->string('Estado')->nullable();
            $table->float('Total')->nullable();
            $table->string('Observaciones')->nullable();
            $table->integer('NumeroTurno')->nullable();
            $table->integer('ReferenciaTurno')->nullable();
            $table->float('AjusteCtaCtePlanillaTurno')->nullable();
            $table->integer('IdEntorno')->nullable();
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->nullable()->constrained('users')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->nullable()->constrained('users')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->boolean('Activo')->nullable();
            $table->float('PuntoVentaNumero')->nullable();
            $table->string('IdClienteEstado')->nullable();
            $table->string('IdClienteFechaEmisionPuntoVentaNumero')->nullable();
            $table->integer('CantidadImpresiones')->nullable();
            $table->integer('CantidadEnviosPorCorreo')->nullable();
            $table->boolean('Archivado')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_trabajo');
    }
};
