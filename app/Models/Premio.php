<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Premio extends Model
{
    protected $table = 'premio';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'FechaDesde',
        'FechaHasta',
        'Premio',
        'Estado',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
    ];

    public function itemsPremio()
    {
        return $this->hasMany(ItemPremio::class, 'IdPremio');
    }
}
