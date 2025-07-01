<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionGlobal extends Model
{
    protected $table = 'configuracion_global';
    public $timestamps = false;

    protected $fillable = [
        'USD_ARS',
        'FechaActualizacionUSD_ARS',
    ];
}