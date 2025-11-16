<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCodigoComplejidadRequest extends FormRequest
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
        session()->put([
            'modal' => 'edit',
        ]);

        return [
            'IdTratamiento' => 'integer|exists:tratamiento,id',
            'Descripcion' => 'required|string|max:255',
            'Precio' => 'required|numeric',
            'Divisa' => 'required|string|max:255',
            'PorcentajeCoeficiente' => 'required|numeric',
            'Coeficiente' => 'required|numeric',
            'CC' => 'required|integer',
            'FechaCreacion' => 'nullable|date',
            'CreadoPor' => 'integer|exists:users,id',
            'FechaActualizacion' => 'nullable|date',
            'ActualizadoPor' => 'integer|exists:users,id',
            'Activo' => 'boolean',
        ];
    }
}
