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
        Schema::create('secuencia_pto_venta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdPtoVenta')->constrained('pto_venta')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->foreignId('IdTipoCbte')->constrained('tipo_cbte')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->integer('Secuencia');
            $table->boolean('ImprimirNumero');
            $table->boolean('ImprimirNumeroCompleto');
            $table->boolean('ImprimirTipoCbte');
            $table->string('NombreTipoCbte')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secuencia_pto_venta');
    }
};
