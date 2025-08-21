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
        Schema::create('minuta_compra', function (Blueprint $table) {
            $table->id();
            $table->integer('Numero');
            $table->string('NumeroCompleto');
            $table->date('FechaEmision');
            $table->foreignId('IdProveedor')->nullable()->constrained('proveedor')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->string('TipoOperacion');
            $table->string('Estado');
            $table->float('Total');
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
        Schema::dropIfExists('minuta_compra');
    }
};
