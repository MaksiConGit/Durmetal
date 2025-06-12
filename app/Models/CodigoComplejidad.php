<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoComplejidad extends Model
{
    protected $table = 'codigo_complejidad';
    public $timestamps = false;

    protected $fillable = [
        'IdTratamiento',
        'Descripcion',
        'Precio',
        'Divisa',
        'PorcentajeCoeficiente',
        'Coeficiente',
        'CC',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
        'IdTratamientoCodigoComplejidad',
    ];

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class, 'IdTratamiento');
    }
}
