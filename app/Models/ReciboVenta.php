<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReciboVenta extends Model
{
    protected $table = 'recibo_venta';
    public $timestamps = false;

    protected $fillable = [
        'Letra',
        'PuntoVenta',
        'Numero',
        'NumeroCompleto',
        'FechaEmision',
        'IdCliente',
        'RazonSocial',
        'IdCondicionIva',
        'TipoDocumentoCliente',
        'NumeroDocumentoCliente',
        'Direccion',
        'Localidad',
        'RetencionDREI',
        'RetencionIIBB',
        'RetencionIVA',
        'RetencionGanancias',
        'RetencionSUSS',
        'Estado',
        'Total',
        'Observaciones',
        'NumeroTurno',
        'ReferenciaTurno',
        'AfectarPlanillaTurno',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
        'LetraNumeroCompleto',
        'CantidadImpresiones',
        'CantidadEnviosPorCorreo',
        'DescripcionSaldoTransportado',
        'ImporteSaldoTransportado',
    ];


    public function cliente()
    {
        return $this->belongsTo(Client::class, 'IdCliente');
    }

    public function itemsReciboVenta()
    {
        return $this->hasMany(ItemReciboVenta::class, 'IdReciboVenta');
    }
}
