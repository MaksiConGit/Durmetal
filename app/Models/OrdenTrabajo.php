<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    protected $table = 'orden_trabajo';
    public $timestamps = false;

    protected $fillable = [
        // Campos validados actualmente
        'PuntoVenta',
        'Numero',
        'NumeroRemitoCliente',
        'FechaEmision',
        'IdCliente',

        // Campos comentados en las reglas de validación (por si se usan después)
        'Letra',
        'NumeroCompleto',
        'FechaVencimiento',
        'AfectarPlanillaTurno',
        'CondicionPrecios',
        'RazonSocial',
        'IdCondicionIva',
        'TipoDocumentoCliente',
        'NumeroDocumentoCliente',
        'Direccion',
        'Localidad',
        'Provincia',
        'Estado',
        'Total',
        'Observaciones',
        'NumeroTurno',
        'ReferenciaTurno',
        'AjusteCtaCtePlanillaTurno',
        'PuntoVentaNumero',
        'IdClienteEstado',
        'IdClienteFechaEmisionPuntoVentaNumero',
        'CantidadImpresiones',
        'CantidadEnviosPorCorreo',
        'Archivado',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
        'Activo',
    ];

    public function itemsOrdenTrabajo()
    {
        return $this->hasMany(ItemOrdenTrabajo::class, 'IdOrdenTrabajo');
    }

    public function cliente()
    {
        return $this->belongsTo(Client::class, 'IdCliente');
    }
}
