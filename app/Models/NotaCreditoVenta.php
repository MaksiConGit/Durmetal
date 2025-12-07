<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaCreditoVenta extends Model
{
    protected $table = 'nota_credito_venta';
    public $timestamps = false;

    protected $fillable = [
        'IdFacturaVenta',
        'Letra',
        'PuntoVenta',
        'Numero',
        'NumeroCompleto',
        'FechaEmision',
        'FechaVencimiento',
        'FechaEstadisticas',
        'TipoOperacion',
        'CondicionPrecios',
        'IdCliente',
        'RazonSocial',
        'IdCondicionIva',
        'TipoDocumentoCliente',
        'NumeroDocumentoCliente',
        'Direccion',
        'Localidad',
        'Neto',
        'NetoNoGravado',
        'IVA',
        'Exento',
        'ImpuestoInterno',
        'Total',
        'AjusteCtaCtePlanillaTurno',
        'Estado',
        'CAE',
        'FechaVencimientoCAE',
        'IdSolicitudCAE',
        'Observaciones',
        'NumeroTurno',
        'ReferenciaTurno',
        'AfectarPlanillaTurno',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
        'CantidadImpresiones',
        'CantidadEnviosPorCorreo',
    ];


    public function cliente()
    {
        return $this->belongsTo(Client::class, 'IdCliente');
    }

    public function itemsNotaCredito()
    {
        return $this->hasMany(ItemNotaCreditoVenta::class, 'IdNotaCreditoVenta');
    }

    public function condicionIVA()
    {
        return $this->belongsTo(IvaCondition::class, 'IdCondicionIva');
    }

    public function facturaVenta()
    {
        return $this->belongsTo(FacturaVenta::class, 'IdFacturaVenta');
    }
}
