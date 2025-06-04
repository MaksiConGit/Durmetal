<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'id' => 'required|integer',
            'Domicilio' => 'required|string|max:255',
            'Telefono' => 'required|string|max:255',
            'TipoDocumento' => 'required|string',
            'IdCalificacionCliente' => 'required|integer|exists:calificacion_cliente,id',
            'Activo' => 'required|boolean',
            'Nombre' => 'required|string|max:255',
            'IdCondicionIVA' => 'required|integer|exists:condicion_iva,id',
            'IdLocalidad' => 'required|integer|exists:localidad,id',
            'CP' => 'required',
            'NroDocumento' => 'required|integer',
            'Saldo' => 'required|numeric',
            'emails' => 'nullable|array|max:6',
            'emails.*' => 'nullable|email|max:255',
        ];
    }
}
