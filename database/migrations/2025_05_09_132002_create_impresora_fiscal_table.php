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
        Schema::create('impresora_fiscal', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->string('Modelo');
            $table->integer('PuertoCOM');
            $table->integer('VelocidadPrEpson');
            $table->integer('TipoProtocoloPrEpson');
            $table->date('FechaUltimoCierreZ');
            $table->integer('PuertoComOcxIFEpson');
            $table->integer('VelocidadOcxIFEpson');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impresora_fiscal');
    }
};
