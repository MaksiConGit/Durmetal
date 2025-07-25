<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    use HasFactory;

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

    public function tipoProgramacion()
    {
        return $this->belongsTo(TipoProgramacion::class, 'IdTipoProgramacion');
    }

    public function medioEnfriamiento()
    {
        return $this->belongsTo(MedioEnfriamiento::class, 'IdMedioEnfriamiento');
    }

    public function ejecutadoPorOperador()
    {
        return $this->belongsTo(User::class, 'EjecutadoPorOperador');
    }

    public function itemOrdenTrabajo()
    {
        return $this->belongsTo(ItemOrdenTrabajo::class, 'IdItemOrdenTrabajo');
    }

}
