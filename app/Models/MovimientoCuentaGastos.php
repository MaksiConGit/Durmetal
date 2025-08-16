<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoCuentaGastos extends Model
{
    protected $table = 'movimiento_cuenta_gastos';
    public $timestamps = false;

    protected $fillable = [
        'IdCuentaOtrosEgresos',
        'Fecha',
        'FechaPago',
        'Descripcion',
        'Importe',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function cuenta()
    {
        return $this->belongsTo(CuentaOtrosEgresos::class, 'IdCuentaOtrosEgresos');
    }
}
