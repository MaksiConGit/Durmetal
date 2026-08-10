<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOrdenTrabajo extends Model
{
    use HasFactory;

    protected $table = 'item_orden_trabajo';
    public $timestamps = false;
    
    protected $fillable = [
        // Campos validados actualmente
        'IdOrdenTrabajo',
        'IdMaterial',
        'IdTratamiento',
        'IdDureza',
        'Descripcion',
        'Cantidad',
        'Peso',
        'DurezaSolicitadaMinima',
        'DurezaSolicitadaMaxima',
        'Estado',
        'Observaciones',
        'FechaActualizacionEstado',
        'CreadoPor',
        'FechaCreacion',
        'ActualizadoPor',
        'FechaActualizacion',
        'Activo',

        // Campos comentados en las reglas de validación (por si se usan después)
        'ItemNumero',
        'NroDeposito',
        'CodigoComplejidad',
        'Coeficiente',
        'PrecioUnitario',
        'Total',
        'AfectaPlanillaTurno',
        'ControlarStock',
        'CertificadoEmitido',
        'CantidadCertificadosImpresos',
        'CantidadCertificadosEnviadosPorCorreo',
        'CantidadProgramaciones',
        'ConNotaEnvio',
        'IDEstadoConNotaEnvio',
        'IDIdOrdenTrabajoIdMaterialIdTratamientoCodigoComplejidadEstado',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'IdMaterial');
    }

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class, 'IdTratamiento');
    }

    public function dureza()
    {
        return $this->belongsTo(Dureza::class, 'IdDureza');
    }

    public function ordenTrabajo()
    {
        return $this->belongsTo(OrdenTrabajo::class, 'IdOrdenTrabajo');
    }

    public function itemNotaEnvio()
    {
        return $this->belongsTo(ItemNotaEnvio::class, 'IdOrdenTrabajo');
    }

    public function programacion()
    {
        return $this->hasMany(Programacion::class, 'IdItemOrdenTrabajo');
    }

public function codigoComplejidad()
{
    return $this->hasOne(
        \App\Models\CodigoComplejidad::class,
        'CC',
        'CodigoComplejidad'
    )->where(
        'codigo_complejidad.IdTratamiento',
        $this->IdTratamiento
    );
}

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'IdItemOrdenTrabajo');
    }
}
