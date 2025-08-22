<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table = 'banco';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Predeterminado',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
        'Archivado',
    ];

    public function chequesCobro()
    {
        return $this->hasMany(Chequecobro::class, 'IdBanco');
    }

    public function chequesPago()
    {
        return $this->hasMany(Chequepago::class, 'IdBanco');
    }
}
