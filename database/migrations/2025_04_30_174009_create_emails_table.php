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
        Schema::create('email_cliente', function (Blueprint $table) {
            $table->id();
            $table->string('Email');
            $table->foreignId('IdCliente')->constrained('cliente')
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
            $table->string('IdClienteEmail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_cliente');
    }
};
