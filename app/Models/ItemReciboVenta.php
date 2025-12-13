<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemReciboVenta extends Model
{
    protected $table = 'item_recibo_venta';
    public $timestamps = false;

    protected $fillable = [
        'IdReciboVenta',
        'IdFacturaVenta',
        'IdSubiva',
        'Descripcion',
        'Total',
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
}
