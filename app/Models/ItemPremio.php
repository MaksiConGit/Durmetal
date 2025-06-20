<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPremio extends Model
{
    protected $table = 'item_premio';
    public $timestamps = false;

    protected $fillable = [
        'IdPremio',
        'IdUsuario',
        'PremioBase',
        'IndiceBase',
        'Coeficiente',
        'Premio',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'IdUsuario');
    }
}
