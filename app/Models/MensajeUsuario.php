<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajeUsuario extends Model
{
    protected $table = 'mensaje_usuario';
    public $timestamps = false;

    protected $fillable = [
        'IdUsuario',
        'IdTipoMensajeUsuario',
        'FechaHora',
        'Mensaje',
        'Observaciones',
        'Visto',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];
}
