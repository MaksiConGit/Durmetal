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
        Schema::create('pto_venta', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->integer('Numero');
            $table->string('Tipo');
            $table->boolean('NotaCreditoComparteTalonario');
            $table->boolean('NotaDebitoComparteTalonario');
            $table->integer('IdTipoRemitoVentaPorDefecto');
            $table->foreignId('IdImpresoraFiscal')->constrained('impresora_fiscal')
                                                    ->onDelete('restrict')
                                                    ->onUpdate('cascade');
            $table->boolean('UtilizarDomicilioConfiguracionGlobal');
            $table->string('DomicilioEmpresa')->nullable();
            $table->string('TelefonoEmpresa')->nullable();
            $table->string('LocalidadEmpresa')->nullable();
            $table->string('ProvinciaEmpresa')->nullable();
            $table->integer('CodigoSucursal')->nullable();
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->constrained('users')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->constrained('users')
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
        Schema::dropIfExists('pto_venta');
    }
};
