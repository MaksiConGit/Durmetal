<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaVenta extends Model
{
    protected $table = 'factura_venta';
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Client::class, 'IdCliente');
    }

    public function itemsFacturaVenta()
    {
        return $this->hasMany(ItemFacturaVenta::class, 'IdFacturaVenta');
    }
}
