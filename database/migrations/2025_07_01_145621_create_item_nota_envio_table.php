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
        Schema::create('item_nota_envio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdNotaEnvio')->nullable()->constrained('nota_envio')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->foreignId('IdItemOrdenTrabajo')->nullable()->constrained('item_orden_trabajo')
                                                                ->onDelete('restrict')
                                                                ->onUpdate('cascade');
            $table->integer('ItemNumero');
            $table->string('Descripcion');
            $table->float('Cantidad');
            $table->float('Peso');
            $table->integer('CodigoComplejidad');
            $table->float('Coeficiente');
            $table->float('PrecioUnitario');
            $table->float('PorcentajeDescuento');
            $table->float('Total');
            $table->string('Estado')->nullable();
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
        Schema::dropIfExists('item_nota_envio');
    }
};
