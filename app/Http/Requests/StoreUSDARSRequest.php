<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUSDARSRequest extends FormRequest
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
            'USD_ARS' => 'required|numeric|min:1',
            'FechaActualizacionUSD_ARS' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'USD_ARS.required' => 'Debe ingresar un valor para el tipo de cambio USD/ARS.',
            'USD_ARS.numeric' => 'El tipo de cambio debe ser un número.',
            'USD_ARS.min' => 'El valor del tipo de cambio debe ser mayor a 0.',
            'FechaActualizacionUSD_ARS.required' => 'Debe ingresar la fecha de actualización.',
            'FechaActualizacionUSD_ARS.date' => 'La fecha de actualización debe tener un formato válido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'USD_ARS' => 'tipo de cambio USD/ARS',
            'FechaActualizacionUSD_ARS' => 'fecha de actualización',
        ];
    }
}
