<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemFacturaVenta extends Model
{
    protected $table = 'item_factura_venta';
    public $timestamps = false;

    protected $fillable = [
        'IdFacturaVenta',
        'ItemNumero',
        'Descripcion',
        'NroDeposito',
        'Cantidad',
        'PrecioCosto',
        'PrecioUnitarioNeto',
        'PrecioUnitario',
        'IdImpuestoIva',
        'AlicuotaIVA',
        'ImpuestoInterno',
        'ImpuestoCombustible',
        'ImpuestoTV',
        'ImpuestosInternos',
        'Neto',
        'IVA',
        'Total',
        'AfectarPlanillaTurno',
        'ControlarStock',
        'Estado',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function facturaVenta()
    {
        return $this->belongsTo(FacturaVenta::class, 'IdFacturaVenta');
    }

    public function itemFacturaVentaNotaEnvio()
    {
        return $this->hasOne(ItemFacturaVentaNotaEnvio::class, 'IdItemFacturaVenta');
    }
}
