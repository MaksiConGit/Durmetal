<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemNotaEnvio extends Model
{
    protected $table = 'item_nota_envio';
    public $timestamps = false;

    protected $fillable = [
        'IdNotaEnvio',
        'IdItemOrdenTrabajo',
        'ItemNumero',
        'Descripcion',
        'Cantidad',
        'Peso',
        'CodigoComplejidad',
        'Coeficiente',
        'PrecioUnitario',
        'PorcentajeDescuento',
        'Total',
        'Estado',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function itemOrdenTrabajo()
    {
        return $this->belongsTo(ItemOrdenTrabajo::class, 'IdItemOrdenTrabajo');
    }
}
