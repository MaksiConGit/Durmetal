<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    protected $table = 'programacion';
    public $timestamps = false;

    protected $fillable = [
        'IdItemOrdenTrabajo',
        'NumeroProgramacion',
        'DurezaMinima',
        'DurezaMaxima',
        'IdTipoProgramacion',
        'Cantidad',
        'Apto',
        'Reproceso',
        'FechaCreacion',
        'FechaCarga',
        'FechaDescarga',
        'Temperatura',
        'IdMedioEnfriamiento',
        'NumeroHorno',
        'EjecutadoPorOperador',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];
}
