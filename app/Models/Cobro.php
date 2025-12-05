<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    protected $table = 'cobro';
    public $timestamps = false;

    protected $fillable = [
        'IdReciboVenta',
        'FormaPago',
        'Descripcion',
        'Total',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function reciboVenta()
    {
        return $this->belongsTo(ReciboVenta::class, 'IdReciboVenta');
    }
}
