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

    public function medioEnfriamiento()
    {
        return $this->belongsTo(MedioEnfriamiento::class, 'IdMedioEnfriamiento');
    }

    public function ejecutadoPorOperador()
    {
        return $this->belongsTo(User::class, 'EjecutadoPorOperador');
    }

    public function programaciones()
    {
        return $this->belongsToMany(ItemOrdenTrabajo::class, 'IdItemOrdenTrabajo');
    }
}
