<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaVenta extends Model
{
    protected $table = 'factura_venta';
    public $timestamps = false;

    protected $fillable = [
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
        'TipoDocumentoCliente',
        'NumeroDocumentoCliente',
        'Direccion',
        'Localidad',
        'IdCondicionIva',
        'CondicionVenta',
        'Neto',
        'NetoNoGravado',
        'Exento',
        'IVA',
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
        'EsNotaDeDebito',
        'NroFacturaNotaDebito',
        'EntregarMercaderiaConRemitos',
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

    public function itemsFacturaVenta()
    {
        return $this->hasMany(ItemFacturaVenta::class, 'IdFacturaVenta');
    }

    public function condicionIVA()
    {
        return $this->belongsTo(IvaCondition::class, 'IdCondicionIva');
    }
}
