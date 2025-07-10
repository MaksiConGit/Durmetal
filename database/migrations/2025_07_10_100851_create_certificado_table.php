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
        Schema::create('certificado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdItemOrdenTrabajo')->nullable()->constrained('item_orden_trabajo')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->string('Nombre');
            $table->string('NroPlano');
            $table->string('Observaciones')->nullable();
            $table->integer('CantidadImpresiones');
            $table->integer('CantidadEnviosPorCorreo');
            $table->float('Cantidad');
            $table->foreignId('IdUsuario')->nullable()->constrained('users')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->boolean('Predeterminado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificado');
    }
};
