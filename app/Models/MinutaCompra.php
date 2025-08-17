<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinutaCompra extends Model
{
    protected $table = 'minuta_compra';
    public $timestamps = false;

    protected $fillable = [
        'Numero',
        'NumeroCompleto',
        'FechaEmision',
        'IdProveedor',
        'TipoOperacion',
        'Total',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function items()
    {
        return $this->hasMany(ItemMinutaCompra::class, 'IdMinutaCompra');
    }
}
