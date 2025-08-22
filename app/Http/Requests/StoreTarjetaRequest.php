<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTarjetaRequest extends FormRequest
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
            'Nombre'            => 'required|string|max:255',
            'FechaCreacion'     => 'nullable|date',
            'CreadoPor'         => 'nullable|integer|exists:users,id',
            'FechaActualizacion'=> 'nullable|date',
            'ActualizadoPor'    => 'nullable|integer|exists:users,id',
            'Activo'            => 'required|boolean',
            'Archivo'           => 'required|boolean',
        ];
    }
}
