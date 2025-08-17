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
        Schema::create('email_proveedor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdProveedor')->nullable()->constrained('proveedor')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->string('Email');
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->nullable()->constrained('users')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->nullable()->constrained('users')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->boolean('Activo');
            $table->string('IdProveedorEmail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_proveedor');
    }
};
