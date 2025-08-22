<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMensajeUsuario extends Model
{
    protected $table = 'tipo_mensaje_usuario';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Color',
        'ColorFondo',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];
}
