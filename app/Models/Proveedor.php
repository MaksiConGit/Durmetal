<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';
    public $timestamps = false;

    protected $fillable = [
        'IdLocalidad',
        'IdCuentaGastos',
        'Nombre',
        'Direccion',
        'Localidad',
        'Provincia',
        'Telefono',
        'IdCondicionIva',
        'NumeroDocumento',
        'SaldoSistemaAnterior',
        'IdRetencionIIBB',
        'NumeroIIBB',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function condicionIVA()
    {
        return $this->belongsTo(IvaCondition::class, 'IdCondicionIva');
    }

    public function localidad()
    {
        return $this->belongsTo(City::class, 'IdLocalidad');
    }

    public function emails()
    {
        return $this->hasMany(EmailProveedor::class, 'IdProveedor');
    }

    public function retencionIIBB()
    {
        return $this->belongsTo(RetencionIIBB::class, 'IdRetencionIIBB');
    }
}
