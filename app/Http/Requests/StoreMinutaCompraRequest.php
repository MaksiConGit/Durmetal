<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMinutaCompraRequest extends FormRequest
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
            'Numero' => 'required|integer',
            'NumeroCompleto' => 'required|string',
            'FechaEmision' => 'required|date',
            'IdProveedor' => 'nullable|exists:proveedor,id',
            'TipoOperacion' => 'required|string',
            'Total' => 'required|numeric',
            'FechaCreacion' => 'nullable|date',
            'CreadoPor' => 'nullable|exists:users,id',
            'FechaActualizacion' => 'nullable|date',
            'ActualizadoPor' => 'nullable|exists:users,id',
            'Activo' => 'required|boolean',
        ];
    }
}
