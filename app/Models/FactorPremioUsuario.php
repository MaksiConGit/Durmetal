<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactorPremioUsuario extends Model
{
    protected $table = 'factor_premio_usuario';
    public $timestamps = false;

    protected $fillable = [
        'IdUsuario',
        'IdFactorPremio',
        'Valor',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function factorPremio()
    {
        return $this->belongsTo(FactorPremio::class, 'IdFactorPremio');
    }
}
