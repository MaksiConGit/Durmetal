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
        Schema::create('item_factura_venta_nota_envio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IdItemFacturaVenta')->nullable()->constrained('item_factura_venta')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->foreignId('IdNotaEnvio')->nullable()->constrained('nota_envio')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_factura_venta_nota_envio');
    }
};
