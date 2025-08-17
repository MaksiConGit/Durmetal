<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordenpago extends Model
{
    protected $table = 'ordenpago';
    public $timestamps = false;

    protected $fillable = [
        'Letra',
        'PuntoVenta',
        'Numero',
        'NumeroCompleto',
        'FechaEmision',
        'IdProveedor',
        'RazonSocial',
        'Direccion',
        'Localidad',
        'IdCondicionIva',
        'NumeroDocumentoProveedor',
        'Estado',
        'BaseRetencionIIBB',
        'AlicuotaRetencionIIBB',
        'RetencionIIBB',
        'RetencionIVA',
        'RetencionGanancias',
        'RetencionSUSS',
        'Total',
        'Observaciones',
        'NumeroTurno',
        'ReferenciaTurno',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
        'CantidadEnviosPorCorreo',
        'CantidadImpresiones',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'IdOrdenPago');
    }
}
