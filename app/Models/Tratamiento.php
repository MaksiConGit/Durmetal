<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tratamiento extends Model
{
    use HasFactory;
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
