<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactorPremio extends Model
{
    protected $table = 'factor_premio';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'ValorPredeterminado',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo'
    ];
}
