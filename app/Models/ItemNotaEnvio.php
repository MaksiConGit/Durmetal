<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemNotaEnvio extends Model
{
    protected $table = 'item_nota_envio';
    public $timestamps = false;

    public function itemOrdenTrabajo()
    {
        return $this->belongsTo(ItemOrdenTrabajo::class, 'IdItemOrdenTrabajo');
    }
}
