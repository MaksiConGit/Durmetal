<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Domicilio',
        'IdLocalidad',
        'Telefono',
        'IdCondicionIVA',
        'TipoDocumento',
        'NroDocumento',
        'LimiteSaldo',
        'SaldoSistemaAnterior',
        'Saldo',
        'CtaCteHabilitada',
        'CondicionPrecios',
        'Categoria',
        'FechaUltimoMovimiento',
        'EsCuentaMaestra',
        'ValidarCuentaPorSaldoActual',
        'IncluirRemitosEnSaldo',
        'IdTipoCliente',
        'IdCalificacionCliente',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo'
    ];

    public function condicionIVA()
    {
        return $this->belongsTo(IvaCondition::class, 'IdCondicionIVA');
    }

    public function calificacionCliente()
    {
        return $this->belongsTo(ClientQualification::class, 'IdCalificacionCliente');
    }

    public function localidad()
    {
        return $this->belongsTo(City::class, 'IdLocalidad');
    }

    public function emails()
    {
        return $this->hasMany(Email::class, 'IdCliente');
    }

    public function ordenesTrabajo()
    {
        return $this->hasMany(OrdenTrabajo::class, 'IdCliente');
    }

    public function notasDeEnvio()
    {
        return $this->hasMany(NotaEnvio::class, 'IdCliente');
    }

    public function facturas()
    {
        return $this->hasMany(FacturaVenta::class, 'IdCliente');
    }
}
