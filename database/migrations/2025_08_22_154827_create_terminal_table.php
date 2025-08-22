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
        Schema::create('terminal', function (Blueprint $table) {
            $table->id();
            $table->string('NombreHost');
            $table->foreignId('IdImpresoraFiscal')->nullable()->constrained('impresora_fiscal')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->string('NombreEtiquetadora');
            $table->dateTime('FechaActualizacion');
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
        Schema::dropIfExists('terminal');
    }
};
