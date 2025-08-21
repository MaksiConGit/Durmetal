<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaCreditoCompra extends Model
{
    protected $table = 'nota_credito_compra';
    public $timestamps = false;

    protected $fillable = [
        'IdFacturaCompra',
        'Letra',
        'PuntoVenta',
        'Numero',
        'NumeroCompleto',
        'FechaEmision',
        'FechaRegistro',
        'FechaVencimiento',
        'TipoOperacion',
        'IdProveedor',
        'IdCondicionIva',
        'NumeroDocumentoProveedor',
        'Neto',
        'AjusteNeto',
        'IVA',
        'AjusteIVA',
        'ImpuestoInterno',
        'ImpuestoCombustible',
        'ImpuestoTV',
        'ConceptosNoGravados',
        'PercepcionIIBB',
        'PercepcionIVA',
        'PercepcionGanancias',
        'Sellados',
        'Bonificacion',
        'Recargo',
        'AjustePorRedondeo',
        'Total',
        'Estado',
        'CAE',
        'FechaVencimientoCAE',
        'Observaciones',
        'NumeroTurno',
        'ReferenciaTurno',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
        'LetraPuntoVentaNumeroIdProveedor2',
    ];

    public function items()
    {
        return $this->hasMany(ItemNotaCreditoCompra::class, 'IdNotaCreditoCompra');
    }

    public function condicionIVA()
    {
        return $this->belongsTo(IvaCondition::class, 'IdCondicionIva');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'IdProveedor');
    }

    public function facturaCompra()
    {
        return $this->belongsTo(Facturacompra::class, 'IdFacturaCompra');
    }
}
