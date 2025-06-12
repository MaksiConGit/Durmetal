<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    protected $table = 'tratamiento';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Predeterminado',
        'Coeficiente',
        'Orden',
        'Predeterminado',
        'Archivado',
    ];

    public function precios()
    {
        return $this->hasMany(CodigoComplejidad::class, 'IdTratamiento');
    }
}
