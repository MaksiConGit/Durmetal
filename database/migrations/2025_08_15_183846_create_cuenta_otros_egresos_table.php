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
        Schema::create('cuenta_otros_egresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdCuentaOtrosEgresosPadre')->nullable()->default(null)->constrained('cuenta_otros_egresos')
                                                                        ->onDelete('restrict')
                                                                        ->onUpdate('cascade');
            $table->string('Nombre');
            $table->string('Descripcion')->nullable();
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->nullable()->constrained('users')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->nullable()->constrained('users')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->boolean('Archivado')->nullable()->default(0);
            $table->boolean('Activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuenta_otros_egresos');
    }
};
