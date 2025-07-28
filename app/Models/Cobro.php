<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    protected $table = 'cobro';
    public $timestamps = false;

    public function reciboVenta()
    {
        return $this->belongsTo(ReciboVenta::class, 'IdReciboVenta');
    }
}
