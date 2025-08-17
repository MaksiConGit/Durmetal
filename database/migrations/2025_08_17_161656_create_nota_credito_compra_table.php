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
        Schema::create('nota_credito_compra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdFacturaCompra')->nullable()->constrained('facturacompra')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->string('Letra');
            $table->integer('PuntoVenta');
            $table->integer('Numero');
            $table->string('NumeroCompleto');
            $table->date('FechaEmision');
            $table->date('FechaRegistro');
            $table->date('FechaVencimiento');
            $table->string('TipoOperacion')->nullable();
            $table->foreignId('IdProveedor')->nullable()->constrained('proveedor')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->foreignId('IdCondicionIva')->nullable()->constrained('condicion_iva')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->string('NumeroDocumentoProveedor');
            $table->float('Neto')->nullable();
            $table->float('AjusteNeto');
            $table->float('IVA')->nullable();
            $table->float('AjusteIVA');
            $table->float('ImpuestoInterno');
            $table->float('ImpuestoCombustible');
            $table->float('ImpuestoTV');
            $table->float('ConceptosNoGravados');
            $table->float('PercepcionIIBB');
            $table->float('PercepcionIVA');
            $table->float('PercepcionGanancias');
            $table->float('Sellados');
            $table->float('Bonificacion');
            $table->float('Recargo');
            $table->float('AjustePorRedondeo');
            $table->float('Total')->nullable();
            $table->string('Estado');
            $table->integer('CAE');
            $table->date('FechaVencimientoCAE')->nullable();
            $table->string('Observaciones')->nullable();
            $table->integer('NumeroTurno');
            $table->integer('ReferenciaTurno');
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->nullable()->constrained('users')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->nullable()->constrained('users')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->boolean('Activo');
            $table->string('LetraPuntoVentaNumeroIdProveedor2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_credito_compra');
    }
};
