<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itemfacturacompra extends Model
{
    protected $table = 'itemfacturacompra';
    public $timestamps = false;

    protected $fillable = [
        'IdFacturaCompra',
        'IdCuentaGastos',
        'Descripcion',
        'NroDeposito',
        'Cantidad',
        'PrecioUnitario',
        'IdImpuestoIva',
        'AlicuotaIVA',
        'Total',
        'AjusteTotal',
        'AfectarPlanillaTurno',
        'ControlarStock',
        'Estado',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function facturaCompra()
    {
        return $this->belongsTo(Facturacompra::class, 'IdFacturaCompra');
    }

    public function cuentaGastos()
    {
        return $this->belongsTo(CuentaGastos::class, 'IdCuentaGastos');
    }
}
