<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFactorPremioRequest extends FormRequest
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
            'ValorPredeterminado' => 'required|numeric',
            'FechaCreacion' => 'nullable|date',
            'CreadoPor' => 'integer|exists:users,id',
            'FechaActualizacion' => 'nullable|date',
            'ActualizadoPor' => 'integer|exists:users,id',
            'Activo' => 'boolean',
        ];
    }
}
