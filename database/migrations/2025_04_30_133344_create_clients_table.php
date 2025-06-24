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
            $table->float('LimiteSaldo')->nullable();
            $table->float('SaldoSistemaAnterior')->nullable();
            $table->float('Saldo');
            $table->boolean('CtaCteHabilitada')->nullable();
            $table->string('CondicionPrecios')->nullable();
            $table->string('Categoria')->nullable();
            $table->date('FechaUltimoMovimiento')->nullable();
            $table->boolean('EsCuentaMaestra')->nullable();
            $table->boolean('ValidarCuentaPorLimiteSaldo')->nullable();
            $table->boolean('ValidarCuentaPorSaldoActual')->nullable();
            $table->boolean('IncluirRemitosEnSaldo')->nullable();
            $table->foreignId('IdTipoCliente')->nullable()
                                            ->constrained('tipo_cliente')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->foreignId('IdCalificacionCliente')->constrained('calificacion_cliente')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->dateTime('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->constrained('users')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->dateTime('FechaActualizacion')->nullable();
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
        Schema::dropIfExists('cliente');
    }
};
