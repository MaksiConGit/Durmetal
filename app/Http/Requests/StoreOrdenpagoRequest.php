<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrdenpagoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Letra' => 'required|string|max:1',
            'PuntoVenta' => 'required|integer',
            'Numero' => 'required|integer',
            'NumeroCompleto' => 'required|string',
            'FechaEmision' => 'required|date',
            'IdProveedor' => 'nullable|exists:proveedor,id',
            'RazonSocial' => 'required|string',
            'Direccion' => 'required|string',
            'Localidad' => 'required|string',
            'IdCondicionIva' => 'nullable|exists:condicion_iva,id',
            'NumeroDocumentoProveedor' => 'required|string',
            'Estado' => 'required|string',
            'BaseRetencionIIBB' => 'nullable|numeric',
            'AlicuotaRetencionIIBB' => 'nullable|numeric',
            'RetencionIIBB' => 'nullable|numeric',
            'RetencionIVA' => 'nullable|numeric',
            'RetencionGanancias' => 'nullable|numeric',
            'RetencionSUSS' => 'nullable|numeric',
            'Total' => 'required|numeric',
            'Observaciones' => 'nullable|string',
            'NumeroTurno' => 'required|integer',
            'ReferenciaTurno' => 'required|integer',
            'FechaCreacion' => 'nullable|date',
            'CreadoPor' => 'nullable|exists:users,id',
            'FechaActualizacion' => 'nullable|date',
            'ActualizadoPor' => 'nullable|exists:users,id',
            'Activo' => 'required|boolean',
            'CantidadEnviosPorCorreo' => 'nullable|integer',
            'CantidadImpresiones' => 'nullable|integer',
        ];
    }
}
