<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemNotaCreditoCompra extends Model
{
    protected $table = 'item_nota_credito_compra';
    public $timestamps = false;

    protected $fillable = [
        'IdNotaCreditoCompra',
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
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function notaCreditoCompra()
    {
        return $this->belongsTo(NotaCreditoCompra::class, 'IdNotaCreditoCompra');
    }

    public function cuentaGastos()
    {
        return $this->belongsTo(CuentaGastos::class, 'IdCuentaGastos');
    }
}
