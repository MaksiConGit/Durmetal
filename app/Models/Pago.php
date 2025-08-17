<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pago';
    public $timestamps = false;

    protected $fillable = [
        'IdOrdenPago',
        'FormaPago',
        'Descripcion',
        'Total',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function ordenPago()
    {
        return $this->belongsTo(Ordenpago::class, 'IdOrdenPago');
    }
}
