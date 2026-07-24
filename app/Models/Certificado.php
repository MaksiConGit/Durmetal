<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $table = 'certificado';
    public $timestamps = false;

    protected $fillable = [
        'IdItemOrdenTrabajo',
        'Nombre',
        'NroPlano',
        'CantidadImpresiones',
        'CantidadEnviosPorCorreo',
        'Cantidad',
        'IdUsuario',
        'Observaciones',
        'Predeterminado',
    ];

    public function itemOrdenTrabajo()
    {
        return $this->belongsTo(ItemOrdenTrabajo::class, 'IdItemOrdenTrabajo');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'IdUsuario');
    }
}