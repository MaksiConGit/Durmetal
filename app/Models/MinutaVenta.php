<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinutaVenta extends Model
{
    protected $table = 'minuta_venta';
    public $timestamps = false;

    public function itemsMinuta()
    {
        return $this->hasMany(ItemMinutaVenta::class, 'IdMinutaVenta');
    }
}
