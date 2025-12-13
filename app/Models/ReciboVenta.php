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

    public function cobros()
    {
        return $this->hasMany(Cobro::class, 'IdReciboVenta');
    }

    public function cobroEfectivo()
    {
        return $this->hasOne(Cobro::class, 'IdReciboVenta')->where('FormaPago', 'EFECTIVO');
    }

    public function cobrosTransferencia()
    {
        return $this->hasMany(Cobro::class, 'IdReciboVenta')->where('FormaPago', 'TRANSFERENCIA');
    }

    public function cobrosCheque()
    {
        return $this->hasMany(Cobro::class, 'IdReciboVenta')->where('FormaPago', 'CHEQUE');
    }

    public function cobrosTarjeta()
    {
        return $this->hasMany(Cobro::class, 'IdReciboVenta')->where('FormaPago', 'TARJETA');
    }
}
