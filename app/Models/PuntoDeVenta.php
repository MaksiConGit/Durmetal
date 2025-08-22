<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoDeVenta extends Model
{
    protected $table = 'pto_venta';
    public $timestamps = false;

protected $fillable = [
    'Nombre',
    'Numero',
    'Tipo',
    'NotaCreditoComparteTalonario',
    'NotaDebitoComparteTalonario',
    'IdTipoRemitoVentaPorDefecto',
    'IdImpresoraFiscal',
    'UtilizarDomicilioConfiguracionGlobal',
    'DomicilioEmpresa',
    'TelefonoEmpresa',
    'LocalidadEmpresa',
    'ProvinciaEmpresa',
    'CodigoSucursal',
    'FechaCreacion',
    'CreadoPor',
    'FechaActualizacion',
    'ActualizadoPor',
    'Activo',
];

}
