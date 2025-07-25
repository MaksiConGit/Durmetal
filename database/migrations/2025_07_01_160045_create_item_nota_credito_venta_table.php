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
        Schema::create('item_nota_credito_venta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdNotaCreditoVenta')->nullable()->constrained('nota_credito_venta')
                                                                ->onDelete('restrict')
                                                                ->onUpdate('cascade');
            $table->integer('ItemNumero');
            // $table->foreignId('IdArticulo')->nullable()->constrained('factura_venta')
            //                                                 ->onDelete('restrict')
            //                                                 ->onUpdate('cascade');
            $table->string('Descripcion');
            $table->integer('NroDeposito');
            $table->float('Cantidad');
            $table->float('PrecioCosto');
            $table->float('PrecioUnitarioNeto');
            $table->float('PrecioUnitario');
            $table->float('AlicuotaIVA');
            $table->float('ImpuestoInterno');
            $table->float('ImpuestoCombustible');
            $table->float('ImpuestoTV');
            $table->float('ImpuestosInternos');
            $table->float('Neto');
            $table->foreignId('IdImpuestoIva')->nullable()->constrained('impuesto_iva')
                                                ->onDelete('restrict')
                                                ->onUpdate('cascade');
            $table->float('IVA');
            $table->float('Total');
            $table->boolean('AfectarPlanillaTurno');
            $table->boolean('ControlarStock');
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
        Schema::dropIfExists('item_nota_credito_venta');
    }
};
