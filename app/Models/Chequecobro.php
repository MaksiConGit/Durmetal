<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chequecobro extends Model
{
    protected $table = 'chequecobro';
    public $timestamps = false;

    protected $fillable = [
        'IdCobro',
        'FechaEmision',
        'FechaAcreditacion',
        'IdBanco',
        'Numero',
        'IdDestinoCheque',
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

    public function cobro()
    {
        return $this->belongsTo(Cobro::class, 'IdCobro');
    }
}
