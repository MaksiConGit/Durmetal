<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemNotaCreditoVenta extends Model
{
    protected $table = 'item_nota_credito_venta';
    public $timestamps = false;

    protected $fillable = [
        'IdNotaCreditoVenta',
        'ItemNumero',
        'IdArticulo',
        'Descripcion',
        'NroDeposito',
        'Cantidad',
        'PrecioCosto',
        'PrecioUnitarioNeto',
        'PrecioUnitario',
        'AlicuotaIVA',
        'ImpuestosInternos',
        'ImpuestoCombustible',
        'ImpuestoTV',
        'ImpuestoInterno',
        'Neto',
        'IdImpuestoIva',
        'IVA',
        'Total',
        'AfectarPlanillaTurno',
        'ControlarStock',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

}
