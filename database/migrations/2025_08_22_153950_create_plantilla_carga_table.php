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
        Schema::create('plantilla_carga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdTratamiento')->nullable()->constrained('tratamiento')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->foreignId('IdMaterial')->nullable()->constrained('material')
                                                                ->onDelete('restrict')
                                                                ->onUpdate('cascade');
            $table->foreignId('IdTipoProgramacion')->nullable()->constrained('tipo_programacion')
                                                                ->onDelete('restrict')
                                                                ->onUpdate('cascade');
            $table->integer('Temperatura');
            $table->foreignId('IdMedioEnfriamiento')->nullable()->constrained('medio_enfriamiento')
                                                                ->onDelete('restrict')
                                                                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_carga');
    }
};
