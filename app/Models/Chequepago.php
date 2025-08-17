<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chequepago extends Model
{
    protected $table = 'chequepago';
    public $timestamps = false;

    protected $fillable = [
        'IdPago',
        'FechaEmision',
        'FechaAcreditacion',
        'IdBanco',
        'Numero',
        'Plaza',
        'eCheck',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'IdBanco');
    }

    public function pago()
    {
        return $this->belongsTo(Pago::class, 'IdPago');
    }
}
