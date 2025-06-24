<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgramacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Cantidad' => 'required|numeric|min:0',
            'Reproceso' => 'boolean',
            'FechaCarga' => 'required|date_format:Y-m-d\TH:i',
            'FechaDescarga' => 'date|after_or_equal:FechaCarga|date_format:Y-m-d\TH:i',
            'Temperatura' => 'numeric',
            'IdMedioEnfriamiento' => 'integer|exists:medio_enfriamiento,id',
            'NumeroHorno' => 'string|max:20',
            'EjecutadoPorOperador' => 'required|integer|exists:users,id',
            'FechaActualizacion' => 'nullable|date',
            'ActualizadoPor' => 'integer|exists:users,id',
        ];
    }
}
