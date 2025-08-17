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
        Schema::create('itemfacturacompra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdFacturaCompra')->nullable()->constrained('facturacompra')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            // $table->foreignId('IdArticulo')->nullable()->constrained('factura_venta')
            //                                                 ->onDelete('restrict')
            //                                                 ->onUpdate('cascade');
            $table->foreignId('IdCuentaGastos')->nullable()->constrained('cuenta_gastos')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->string('Descripcion');
            $table->integer('NroDeposito');
            $table->float('Cantidad');
            $table->float('PrecioUnitario')->nullable();
            $table->foreignId('IdImpuestoIva')->nullable()->constrained('impuesto_iva')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->float('AlicuotaIVA');
            $table->float('Total');
            $table->float('AjusteTotal');
            $table->boolean('AfectarPlanillaTurno');
            $table->boolean('ControlarStock');
            $table->string('Estado');
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->nullable()->constrained('users')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->nullable()->constrained('users')
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
        Schema::dropIfExists('itemfacturacompra');
    }
};
