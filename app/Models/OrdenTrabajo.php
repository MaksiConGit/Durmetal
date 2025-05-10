<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    protected $table = 'orden_trabajo';
    public $timestamps = false;

    public function itemsOrdenTrabajo()
    {
        return $this->hasMany(ItemOrdenTrabajo::class, 'IdOrdenTrabajo');
    }
}
