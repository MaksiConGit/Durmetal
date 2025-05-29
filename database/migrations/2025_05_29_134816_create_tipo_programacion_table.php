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
        Schema::create('tipo_programacion', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->string('Tipo');
            $table->string('Orden');
            $table->string('Predeterminado');
            $table->string('RequiereNumeracionSiempre');
            $table->string('NombreTipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_programacion');
    }
};
