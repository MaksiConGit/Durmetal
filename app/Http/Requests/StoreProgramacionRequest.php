<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'NumeroProgramacion' => 'required|array',
            'NumeroProgramacion.*' => 'nullable|string|max:50',
            'DurezaMinima' => 'numeric|min:0',
            'DurezaMaxima' => 'numeric|min:0|gte:DurezaMinima',
            'IdTipoProgramacion' => 'required|integer|exists:tipo_programacion,id',
            'Apto' => 'nullable|boolean',
            'Reproceso.*' => 'boolean',
            'FechaCreacion' => 'nullable|date',
            'FechaCarga' => 'required|date_format:Y-m-d\TH:i',
            'FechaDescarga' => 'date|after_or_equal:FechaCarga|date_format:Y-m-d\TH:i',
            'Temperatura' => 'numeric',
            'IdMedioEnfriamiento' => 'integer|exists:medio_enfriamiento,id',
            'NumeroHorno' => 'string|max:20',
            'EjecutadoPorOperador' => 'required|integer|exists:users,id',
            'CreadoPor' => 'integer|exists:users,id',
            'FechaActualizacion' => 'nullable|date',
            'ActualizadoPor' => 'integer|exists:users,id',
            'Activo' => 'boolean',
            // 'Cantidad.*' => 'required|numeric|min:0',
            // 'CantidadFinal.*' => 'required|numeric|min:0',
            // 'Cantidad' => 'required|numeric|min:0',
            // 'IdItemOrdenTrabajo' => 'required|integer|exists:items_orden_trabajo,id',
        ];
    }
}
