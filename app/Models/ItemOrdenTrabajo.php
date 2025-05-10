<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemOrdenTrabajo extends Model
{
    protected $table = 'item_orden_trabajo';
    public $timestamps = false;

    public function material()
    {
        return $this->belongsTo(Material::class, 'IdMaterial');
    }

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class, 'IdMaterial');
    }

    public function dureza()
    {
        return $this->belongsTo(Dureza::class, 'IdMaterial');
    }
}
