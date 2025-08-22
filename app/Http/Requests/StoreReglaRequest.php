<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReglaRequest extends FormRequest
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
            'IdPuntoEntrada'      => 'nullable|integer|exists:punto_entrada,id',
            'Nombre'              => 'required|string|max:255',
            'SecuenciaCondiciones'=> 'required|string|max:2000',
            'Orden'               => 'required|integer|min:0',
        ];
    }
}
