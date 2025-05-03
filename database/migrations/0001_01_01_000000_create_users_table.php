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
        Schema::create('Usuario', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->string('Usuario')->unique();
            $table->boolean('SuperUsuario');
            $table->string('Email')->unique();
            $table->boolean('NotificarErroresPorEmail');
            $table->boolean('EnviarReportePlanillaTurno');
            $table->boolean('UtilizarTurnoEntorno');
            $table->string('ArticuloShopPorDefecto');
            $table->string('NroTablero');
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->constrained('Usuario')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->constrained('Usuario')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->string('Firma')->nullable();
            $table->boolean('Activo');
            $table->boolean('CobraPremio');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Usuario');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
