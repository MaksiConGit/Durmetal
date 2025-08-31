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
        Schema::create('arti', function (Blueprint $table) {
            $table->id();
            $table->integer('CODART')->nullable();
            $table->integer('RUBART')->nullable();
            $table->integer('MAAART')->nullable();
            $table->integer('ROBART')->nullable();
            $table->integer('PROART')->nullable();
            $table->foreignId('IdImpuestoIva')->nullable()->constrained('impuesto_iva')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->string('DESART');
            $table->string('CTRART')->nullable();
            $table->string('BARART')->nullable();
            $table->string('IVAART')->nullable();
            $table->string('UNIART')->nullable();
            $table->string('CANART')->nullable();
            $table->float('ImpuestoInterno')->nullable();
            $table->float('ITC')->nullable();
            $table->float('TV')->nullable();
            $table->float('ITCART')->nullable();
            $table->float('MARART')->nullable();
            $table->float('MA2ART')->nullable();
            $table->float('MA3ART')->nullable();
            $table->float('PR0ART')->nullable();
            $table->float('PR1ART')->nullable();
            $table->float('PR2ART')->nullable();
            $table->float('PR3ART')->nullable();
            $table->float('PR4ART')->nullable();
            $table->float('PR5ART')->nullable();
            $table->float('PR6ART')->nullable();
            $table->integer('PR7ART')->nullable();
            $table->integer('PR8ART')->nullable();
            $table->string('ACTART')->nullable();
            $table->string('MINART')->nullable();
            $table->integer('VTOART')->nullable();
            $table->integer('AR1ART')->nullable();
            $table->integer('AR2ART')->nullable();
            $table->integer('AR3ART')->nullable();
            $table->integer('AR4ART')->nullable();
            $table->integer('BRUART')->nullable();
            $table->integer('PB1ART')->nullable();
            $table->integer('PB2ART')->nullable();
            $table->integer('PB3ART')->nullable();
            $table->integer('CA1ART')->nullable();
            $table->integer('CA2ART')->nullable();
            $table->integer('CA3ART')->nullable();
            $table->integer('CA4ART')->nullable();
            $table->integer('GA1ART')->nullable();
            $table->integer('GA2ART')->nullable();
            $table->integer('GA3ART')->nullable();
            $table->integer('GA4ART')->nullable();
            $table->integer('GA5ART')->nullable();
            $table->integer('GA6ART')->nullable();
            $table->integer('GA7ART')->nullable();
            $table->integer('GA8ART')->nullable();
            $table->integer('GA9ART')->nullable();
            $table->integer('GA0ART')->nullable();
            $table->float('IM1ART')->nullable();
            $table->float('IM2ART')->nullable();
            $table->float('IM3ART')->nullable();
            $table->float('IM4ART')->nullable();
            $table->float('IM5ART')->nullable();
            $table->float('IM6ART')->nullable();
            $table->float('IM7ART')->nullable();
            $table->float('IM8ART')->nullable();
            $table->float('IM9ART')->nullable();
            $table->float('IM0ART')->nullable();
            $table->float('CO1ART')->nullable();
            $table->float('CO2ART')->nullable();
            $table->float('CO3ART')->nullable();
            $table->float('CO4ART')->nullable();
            $table->float('CO5ART')->nullable();
            $table->float('CO6ART')->nullable();
            $table->float('CO7ART')->nullable();
            $table->float('CO8ART')->nullable();
            $table->float('CO9ART')->nullable();
            $table->float('CO0ART')->nullable();
            $table->dateTime('FechaActualizacionPrecioCosto')->nullable();
            $table->boolean('AfectarPlanillaTurno')->nullable();
            $table->boolean('ControlarStock')->nullable();
            $table->dateTime('FechaActualizacionPrecioA')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arti');
    }
};
