<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTratamientoRequest extends FormRequest
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
        $tratamiento = $this->route('tratamiento');

        session()->put([
            'modal' => 'edit',
            'tratamiento_id' => $tratamiento->id,
        ]);

        return [
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'required|string|max:255',
            'Predeterminado' => 'required',
        ];
    }
}
