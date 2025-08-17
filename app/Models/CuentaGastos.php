<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaGastos extends Model
{
    protected $table = 'cuenta_gastos';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Descripcion',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function proveedores()
    {
        return $this->hasMany(Proveedor::class, 'IdCuentaGastos');
    }
}
