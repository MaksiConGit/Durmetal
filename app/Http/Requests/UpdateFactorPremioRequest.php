<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFactorPremioRequest extends FormRequest
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
        $factor_premio = $this->route('factor_premio');

        session()->put([
            'modal' => 'edit',
            'factor_premio_id' => $factor_premio->id,
        ]);

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
