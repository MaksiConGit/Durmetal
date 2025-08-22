<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePuntoVentaRequest extends FormRequest
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
            'Nombre' => 'required|string|max:255',
            'Numero' => 'required|integer|min:0',
            'Tipo'   => 'required|string|max:50',
            'NotaCreditoComparteTalonario' => 'required|boolean',
            'NotaDebitoComparteTalonario'  => 'required|boolean',
            'IdTipoRemitoVentaPorDefecto'   => 'required|integer',
            'IdImpresoraFiscal'             => 'nullable|integer|exists:impresora_fiscal,id',
            'UtilizarDomicilioConfiguracionGlobal' => 'required|boolean',
            'DomicilioEmpresa'              => 'nullable|string|max:255',
            'TelefonoEmpresa'               => 'nullable|string|max:50',
            'LocalidadEmpresa'              => 'nullable|string|max:100',
            'ProvinciaEmpresa'              => 'nullable|string|max:100',
            'CodigoSucursal'                => 'nullable|integer',
            'FechaCreacion'                 => 'nullable|date',
            'CreadoPor'                     => 'required|integer|exists:users,id',
            'FechaActualizacion'            => 'nullable|date',
            'ActualizadoPor'                => 'required|integer|exists:users,id',
            'Activo'                        => 'required|boolean',
        ];
    }
}
