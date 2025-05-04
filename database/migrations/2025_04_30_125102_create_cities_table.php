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
        Schema::create('localidad', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre')->nullable();
            $table->string('CP');
            $table->foreignId('IdProvincia')->constrained('provincia')
                                                ->onDelete('restrict')
                                                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localidad');
    }
};
