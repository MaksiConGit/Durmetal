<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlantillaCargaRequest extends FormRequest
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
            'IdTratamiento'       => 'nullable|integer|exists:tratamiento,id',
            'IdMaterial'          => 'nullable|integer|exists:material,id',
            'IdTipoProgramacion'  => 'nullable|integer|exists:tipo_programacion,id',
            'Temperatura'         => 'required|integer|min:0',
            'IdMedioEnfriamiento' => 'nullable|integer|exists:medio_enfriamiento,id',
        ];
    }
}
