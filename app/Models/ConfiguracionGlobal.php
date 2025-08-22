<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionGlobal extends Model
{
    protected $table = 'configuracion_global';
    public $timestamps = false;

    protected $fillable = [
        'RazonSocialEmpresa',
        'DomicilioEmpresa',
        'TelefonoEmpresa',
        'CUITEmpresa',
        'IIBBEmpresa',
        'FechaInicioActividadesEmpresa',
        'LocalidadEmpresa',
        'ProvinciaEmpresa',
        'CodigoSucursal',
        'ImporteMinimoRetencionIIBB',
        'CodigoPostalEmpresa',
        'NroAgenteEmpresa',
        'EsAgenteRetencionGanancias',
        'EsAgenteRetencionIIBB',
        'CuentaEmailMembretes',
        'CuentaEmail',
        'ServidorSMTP',
        'PuertoSMTP',
        'UsuarioSMTP',
        'ClaveSMTP',
        'TiempoDeEsperaSMTP',
        'OpcionSMTP',
        'CuentaEmailCCO',
        'RemitenteCCO',
        'XMLLoginTicketRequest',
        'MofoOperacionFE',
        'RutaCertificadoFE',
        'ClaveCertificadoFE',
        'ClaveForzarValidacionCtaCteCliente',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
        'CuentaEmailCertificados',
        'ServidorSMTPCertificados',
        'PuertoSMTPCertificados',
        'UsuarioSMTPCertificados',
        'ClaveSMTPCertificados',
        'TiempoDeEsperaSMTPCertificados',
        'OpcionSMTPCertificados',
        'CuentaEmailCCOCertificados',
        'RemitenteCCOCertificados',
        'ValidarProgramacionesSinDatosDurezas',
        'NombreLogo',
        'PlazoVencimientoFactura',
        'USD_ARS',
        'FechaActualizacionUSD_ARS',
        'FechaEmisionValidaDesde',
        'FechaEmisionValidaHasta',
    ];
}