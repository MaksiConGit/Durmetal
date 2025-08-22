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
        Schema::create('mensaje_usuario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdUsuario')->nullable()->constrained('users')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->foreignId('IdTipoMensajeUsuario')->nullable()->constrained('tipo_mensaje_usuario')
                                                                ->onDelete('restrict')
                                                                ->onUpdate('cascade');
            $table->dateTime('FechaHora');
            $table->string('Mensaje');
            $table->string('Observaciones');
            $table->boolean('Visto');
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
        Schema::dropIfExists('mensaje_usuario');
    }
};
