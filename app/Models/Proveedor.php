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

    public function facturasCompra()
    {
        return $this->hasMany(Facturacompra::class, 'IdProveedor')->where('EsNotaDeDebito', 0);
    }

    public function notasDebitoCompra()
    {
        return $this->hasMany(Facturacompra::class, 'IdProveedor')->where('EsNotaDeDebito', 1);
    }

    public function notasCreditoCompra()
    {
        return $this->hasMany(NotaCreditoCompra::class, 'IdProveedor');
    }

    public function ordenesPago()
    {
        return $this->hasMany(Ordenpago::class, 'IdProveedor');
    }

    public function minutasCompra()
    {
        return $this->hasMany(MinutaCompra::class, 'IdProveedor');
    }
}
