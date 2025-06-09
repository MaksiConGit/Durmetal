<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    protected $table = 'carga';
    public $timestamps = false;

    protected $fillable = [
        'Numero',
        'Referencia',
        'FechaCarga',
        'HoraCarga',
        'FechaDescarga',
        'HoraDescarga',
        'TiempoProceso',
        'TemperaturaProceso',
        'IdMedioEnfriamiento',
        'EjecutadoPorOperador',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
        'NumeroReferencia',
        'NumeroHorno',
        'FechaCargaFechaDescargaNumeroHorno',
    ];
}
