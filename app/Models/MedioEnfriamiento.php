<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedioEnfriamiento extends Model
{
    protected $table = 'medio_enfriamiento';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Orden',
        'Predeterminado',
    ];
}
