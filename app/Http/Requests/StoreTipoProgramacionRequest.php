<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoProgramacionRequest extends FormRequest
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
        session()->put('modal', 'create');

        return [
            'Nombre' => 'required|string|max:255',
            'Tipo' => 'required|string|max:255',
            'Predeterminado' => 'required|boolean',
            'RequiereNumeracionSiempre' => 'required|boolean',
        ];
    }
}
