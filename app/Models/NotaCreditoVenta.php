<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaCreditoVenta extends Model
{
    protected $table = 'nota_credito_venta';
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Client::class, 'IdCliente');
    }
}
