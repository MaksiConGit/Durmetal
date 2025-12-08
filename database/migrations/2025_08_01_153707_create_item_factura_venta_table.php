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
        Schema::create('item_factura_venta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdFacturaVenta')->nullable()->constrained('factura_venta')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->integer('ItemNumero');
            $table->foreignId('IdArticulo')->nullable()->constrained('arti')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->string('Descripcion');
            $table->integer('NroDeposito');
            $table->float('Cantidad');
            $table->float('PrecioCosto');
            $table->float('PrecioUnitarioNeto');
            $table->float('PrecioUnitario');
            $table->foreignId('IdImpuestoIva')->nullable()->constrained('impuesto_iva')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->float('AlicuotaIVA');
            $table->float('ImpuestoInterno');
            $table->float('ImpuestoCombustible');
            $table->float('ImpuestoTV');
            $table->float('ImpuestosInternos');
            $table->float('Neto');
            $table->float('IVA');
            $table->float('Total');
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
        Schema::dropIfExists('item_factura_venta');
    }
};
