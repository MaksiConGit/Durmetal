<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaOtrosEgresos extends Model
{
    protected $table = 'cuenta_otros_egresos';
    public $timestamps = false;

    protected $fillable = [
        'IdCuentaOtrosEgresosPadre',
        'Nombre',
        'Descripcion',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];


    public function hijos()
    {
        return $this->hasMany(CuentaOtrosEgresos::class, 'IdCuentaOtrosEgresosPadre')
                    ->orderBy('Nombre', 'asc');
    }

    public function padre()
    {
        return $this->belongsTo(CuentaOtrosEgresos::class, 'IdCuentaOtrosEgresosPadre');
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoCuentaGastos::class, 'IdCuentaOtrosEgresos');
    }
}
