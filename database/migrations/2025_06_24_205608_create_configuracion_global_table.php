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
        Schema::create('configuracion_global', function (Blueprint $table) {
            $table->id();
            $table->string('RazonSocialEmpresa');
            $table->string('DomicilioEmpresa');
            $table->string('TelefonoEmpresa');
            $table->string('CUITEmpresa');
            $table->string('IIBBEmpresa');
            $table->date('FechaInicioActividadesEmpresa');
            $table->string('LocalidadEmpresa');
            $table->string('ProvinciaEmpresa');
            $table->integer('CodigoSucursal');
            $table->float('ImporteMinimoRetencionIIBB');
            $table->integer('CodigoPostalEmpresa');
            $table->integer('NroAgenteEmpresa')->nullable();
            $table->boolean('EsAgenteRetencionGanancias');
            $table->boolean('EsAgenteRetencionIIBB');
            $table->string('CuentaEmailMembretes');
            $table->string('CuentaEmail');
            $table->string('ServidorSMTP');
            $table->string('PuertoSMTP');
            $table->string('UsuarioSMTP');
            $table->string('ClaveSMTP');
            $table->integer('TiempoDeEsperaSMTP');
            $table->integer('OpcionSMTP');
            $table->string('CuentaEmailCCO')->nullable();
            $table->boolean('RemitenteCCO');
            $table->longText('XMLLoginTicketRequest');
            $table->string('ModoOperacionFE');
            $table->string('RutaCertificadoFE');
            $table->string('ClaveCertificadoFE');
            $table->string('ClaveForzarValidacionCtaCteCliente');
            $table->date('FechaCreacion')->nullable();
            $table->foreignId('CreadoPor')->nullable()->constrained('users')
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->date('FechaActualizacion')->nullable();
            $table->foreignId('ActualizadoPor')->nullable()->constrained('users')
                                                            ->onDelete('restrict')
                                                            ->onUpdate('cascade');
            $table->boolean('Activo');
            $table->string('CuentaEmailCertificados');
            $table->string('ServidorSMTPCertificados');
            $table->integer('PuertoSMTPCertificados');
            $table->string('UsuarioSMTPCertificados');
            $table->string('ClaveSMTPCertificados');
            $table->integer('TiempoDeEsperaSMTPCertificados');
            $table->integer('OpcionSMTPCertificados');
            $table->string('CuentaEmailCCOCertificados')->nullable();
            $table->boolean('RemitenteCCOCertificados');
            $table->boolean('ValidarProgramacionesSinDatosDurezas');
            $table->string('NombreLogo');
            $table->integer('PlazoVencimientoFactura');
            $table->float('USD_ARS');
            $table->date('FechaActualizacionUSD_ARS');
            $table->integer('FechaEmisionValidaDesde');
            $table->integer('FechaEmisionValidaHasta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_global');
    }
};
