<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrdenTrabajoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'PuntoVenta' => 'required|exists:pto_venta,id',
            'Numero' => 'required|integer',
            'NumeroRemitoCliente' => 'nullable|integer',
            'FechaEmision' => 'required|date',
            'IdCliente' => 'required|integer|exists:cliente,id',

            // 'Letra' => 'nullable|string|max:1',
            // 'NumeroCompleto' => 'nullable|string|max:255',
            // 'FechaVencimiento' => 'nullable|date|after_or_equal:FechaEmision',
            // 'AfectarPlanillaTurno' => 'nullable|boolean',
            // 'CondicionPrecios' => 'nullable|string|max:5',
            // 'RazonSocial' => 'nullable|string|max:255',
            // 'IdCondicionIva' => 'nullable|integer|exists:condicion_iva,id',
            // 'TipoDocumentoCliente' => 'nullable|string|max:20',
            // 'NumeroDocumentoCliente' => 'nullable|string|max:20',
            // 'Direccion' => 'nullable|string|max:255',
            // 'Localidad' => 'nullable|string|max:255',
            // 'Provincia' => 'nullable|string|max:255',
            // 'Estado' => 'nullable|string|max:50',
            // 'Total' => 'nullable|numeric|min:0',
            // 'Observaciones' => 'nullable|string',
            // 'NumeroTurno' => 'nullable|integer',
            // 'ReferenciaTurno' => 'nullable|integer',
            // 'AjusteCtaCtePlanillaTurno' => 'nullable|numeric',
            // 'PuntoVentaNumero' => 'nullable|numeric',
            // 'IdClienteEstado' => 'nullable|string|max:255',
            // 'IdClienteFechaEmisionPuntoVentaNumero' => 'nullable|string|max:255',
            // 'CantidadImpresiones' => 'nullable|integer|min:0',
            // 'CantidadEnviosPorCorreo' => 'nullable|integer|min:0',
            // 'Archivado' => 'nullable|boolean',
            // 'FechaCreacion' => 'nullable|date',
            // 'CreadoPor' => 'nullable|integer|exists:users,id',
            // 'FechaActualizacion' => 'nullable|date',
            // 'ActualizadoPor' => 'nullable|integer|exists:users,id',
            // 'Activo' => 'nullable|boolean',
        ];
    }
}
