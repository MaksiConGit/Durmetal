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
        Schema::create('movimiento_cuenta_gastos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdCuentaOtrosEgresos')->nullable()->constrained('cuenta_otros_egresos')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade'); 
            $table->date('Fecha');
            $table->date('FechaPago');
            $table->string('Descripcion');
            $table->float('Importe');
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
        Schema::dropIfExists('movimiento_cuenta_gastos');
    }
};
