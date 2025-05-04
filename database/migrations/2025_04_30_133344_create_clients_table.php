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
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->string('Domicilio')->nullable();
            $table->foreignId('IdLocalidad')->constrained('localidad')
                                                ->onDelete('restrict')
                                                ->onUpdate('cascade');
            $table->string('Telefono')->nullable();
            $table->foreignId('IdCondicionIVA')->constrained('condicion_iva')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->string('TipoDocumento');
            $table->string('NroDocumento')->nullable();
            $table->float('LimiteSaldo');
            $table->float('SaldoSistemaAnterior');
            $table->float('Saldo');
            $table->boolean('CtaCteHabilitada');
            $table->string('CondicionPrecios');
            $table->string('Categoria');
            $table->date('FechaUltimoMovimiento')->nullable();
            $table->boolean('EsCuentaMaestra');
            $table->boolean('ValidarCuentaPorLimiteSaldo');
            $table->boolean('ValidarCuentaPorSaldoActual');
            $table->boolean('IncluirRemitosEnSaldo');
            $table->foreignId('IdTipoCliente')->constrained('tipo_cliente')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->foreignId('IdCalificacionCliente')->constrained('calificacion_cliente')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->constrained('users')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->constrained('users')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->boolean('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
