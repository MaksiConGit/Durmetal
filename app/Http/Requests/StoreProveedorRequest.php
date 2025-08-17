<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProveedorRequest extends FormRequest
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
            'IdLocalidad' => 'required|integer|exists:localidad,id',
            'IdCuentaGastos' => 'nullable|exists:cuenta_gastos,id',
            'Nombre' => 'required|string|max:255',
            'Direccion' => 'required|string|max:255',
            // 'Localidad' => 'required|string|max:255',
            // 'Provincia' => 'required|string|max:255',
            'Telefono' => 'required|string|max:50',
            'IdCondicionIva' => 'nullable|exists:condicion_iva,id',
            'NumeroDocumento' => 'required|string|max:50',
            'IdRetencionIIBB' => 'nullable|exists:retencion_iibb,id',
            'NumeroIIBB' => 'required|integer',
            'emails' => 'nullable|array|max:6',
            'emails.*' => 'nullable|email|max:255',
        ];
    }
}
