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
        Schema::create('impuesto_iva', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->float('Tasa');
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->nullable()->constrained('users')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->nullable()->constrained('users')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->boolean('Activo');
            $table->string('Observaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impuesto_iva');
    }
};
