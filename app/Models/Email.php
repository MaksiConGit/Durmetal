<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'email_cliente';
    public $timestamps = false;

    protected $fillable = [
        'Email',
        'IdCliente',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
        'IdClienteEmail',
    ];
}
