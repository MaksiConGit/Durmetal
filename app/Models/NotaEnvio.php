<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaEnvio extends Model
{
    protected $table = 'nota_envio';
    public $timestamps = false;

    protected $fillable = [
        'Letra', 'PuntoVenta', 'Numero', 'NumeroCompleto', 'FechaEmision', 'FechaVencimiento',
        'AfectarPlanillaTurno', 'CondicionPrecios', 'IdCliente', 'RazonSocial', 'IdCondicionIva',
        'TipoDocumento', 'NumeroDocumentoCliente', 'Direccion', 'Localidad', 'Provincia', 'Estado',
        'TipoOperacion', 'PorcentajeDescuento', 'Neto', 'IVA', 'Total', 'Observaciones',
        'NumeroTurno', 'ReferenciaTurno', 'AjusteCtaCtePlanillaTurno', 'FechaCreacion', 'CreadoPor',
        'FechaActualizacion', 'ActualizadoPor', 'Activo', 'PuntoVentaNumero', 'CantidadImpresiones',
        'CantidadEnviosPorCorreo'
    ];

    public function cliente()
    {
        return $this->belongsTo(Client::class, 'IdCliente');
    }

    public function itemsNotaEnvio()
    {
        return $this->hasMany(ItemNotaEnvio::class, 'IdNotaEnvio');
    }

    public function itemFacturaVentaNotaEnvio()
    {
        return $this->hasOne(ItemFacturaVentaNotaEnvio::class, 'IdNotaEnvio');
    }
}
