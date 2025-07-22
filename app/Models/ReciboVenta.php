<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReciboVenta extends Model
{
    protected $table = 'recibo_venta';
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Client::class, 'IdCliente');
    }
}
