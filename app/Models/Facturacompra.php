<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facturacompra extends Model
{
    protected $table = 'facturacompra';
    public $timestamps = false;

    protected $fillable = [
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
        'EsNotaDeDebito',
        'NroFacturaNotaDebito',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
        'LetraPuntoVentaNumeroIdProveedor',
    ];

    public function itemsFacturaCompra()
    {
        return $this->hasMany(Itemfacturacompra::class, 'IdFacturaCompra');
    }
}
