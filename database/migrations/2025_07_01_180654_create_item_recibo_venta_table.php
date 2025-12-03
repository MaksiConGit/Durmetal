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
        Schema::create('item_recibo_venta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdReciboVenta')->nullable()->constrained('recibo_venta')
                                                                ->onDelete('restrict')
                                                                ->onUpdate('cascade');
            $table->foreignId('IdFacturaVenta')->nullable()->constrained('factura_venta')
                                                                ->onDelete('restrict')
                                                                ->onUpdate('cascade');       
            $table->integer('IdSubiva')->default(0);
            $table->string('Descripcion');
            $table->float('Total');
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
        Schema::dropIfExists('item_recibo_venta');
    }
};
