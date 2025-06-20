<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dureza extends Model
{
    protected $table = 'dureza';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Predeterminado'
    ];
}
