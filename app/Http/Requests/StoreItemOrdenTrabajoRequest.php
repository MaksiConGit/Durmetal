<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemOrdenTrabajoRequest extends FormRequest
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
            'IdOrdenTrabajo' => 'required|exists:orden_trabajo,id',
            'IdMaterial' => 'required|exists:material,id',
            'IdTratamiento' => 'required|exists:tratamiento,id',
            'IdDureza' => 'required|exists:dureza,id',
            'Descripcion' => 'required|string|max:255',
            'Cantidad' => 'required|integer',
            'Peso' => 'required|numeric|min:0',
            'DurezaSolicitadaMinima' => 'required|integer|min:0',
            'DurezaSolicitadaMaxima' => 'required|integer|min:0|gte:DurezaSolicitadaMinima',
            'Estado' => 'required|string|max:50',
            'Observaciones' => 'nullable|string|max:255',
            'ItemNumero' => 'required|integer',
            
            // 'NroDeposito' => 'required|integer',
            // 'CodigoComplejidad' => 'required|integer',
            // 'Coeficiente' => 'required|numeric|min:0',
            // 'PrecioUnitario' => 'required|numeric|min:0',
            // 'Total' => 'required|numeric|min:0',
            // 'AfectaPlanillaTurno' => 'required|boolean',
            // 'ControlarStock' => 'required|boolean',
            // 'CertificadoEmitido' => 'required|boolean',
            // 'CantidadCertificadosImpresos' => 'required|integer|min:0',
            // 'CantidadCertificadosEnviadosPorCorreo' => 'required|integer|min:0',
            // 'CantidadProgramaciones' => 'required|integer|min:0',
            // 'ConNotaEnvio' => 'required|boolean',
            // 'IDEstadoConNotaEnvio' => 'required|string|max:50',
            // 'IDIdOrdenTrabajoIdMaterialIdTratamientoCodigoComplejidadEstado' => 'required|string|max:255',
        ];
    }
}
