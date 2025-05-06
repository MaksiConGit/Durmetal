<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
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
}
