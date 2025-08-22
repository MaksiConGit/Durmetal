<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMensajeUsuarioRequest extends FormRequest
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
            'IdUsuario'             => 'nullable|integer|exists:users,id',
            'IdTipoMensajeUsuario'  => 'nullable|integer|exists:tipo_mensaje_usuario,id',
            'FechaHora'             => 'required|date',
            'Mensaje'               => 'required|string|max:1000',
            'Observaciones'         => 'nullable|string|max:1000',
            'Visto'                 => 'required|boolean',
            'FechaCreacion'         => 'nullable|date',
            'CreadoPor'             => 'nullable|integer|exists:users,id',
            'Activo'                => 'required|boolean',
        ];
    }
}
