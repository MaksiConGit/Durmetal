<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemFacturaVentaNotaEnvio extends Model
{
    protected $table = 'item_factura_venta_nota_envio';
    public $timestamps = false;

    protected $fillable = [
        'IdItemFacturaVenta',
        'IdNotaEnvio',
    ];

    public function itemFacturaVenta()
    {
        return $this->belongsTo(ItemFacturaVenta::class, 'IdItemFacturaVenta');
    }
}
