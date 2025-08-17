<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailProveedor extends Model
{
    protected $table = 'email_proveedor';
    public $timestamps = false;

    protected $fillable = [
        'IdProveedor',
        'Email',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
        'IdProveedorEmail',
    ];
}
