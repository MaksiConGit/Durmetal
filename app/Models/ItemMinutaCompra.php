<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemMinutaCompra extends Model
{
    protected $table = 'item_minuta_compra';
    public $timestamps = false;

    protected $fillable = [
        'IdMinutaCompra',
        'Descripcion',
        'Total',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function minuta()
    {
        return $this->belongsTo(MinutaCompra::class, 'IdMinutaCompra');
    }
}
