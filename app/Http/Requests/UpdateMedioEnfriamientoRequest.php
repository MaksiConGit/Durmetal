<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedioEnfriamientoRequest extends FormRequest
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
        $medio_enfriamiento = $this->route('medio_enfriamiento');

        session()->put([
            'modal' => 'edit',
            'medio_enfriamiento_id' => $medio_enfriamiento->id,
        ]);

        return [
            'Nombre' => 'required|string|max:255',
            'Predeterminado' => 'required',
        ];
    }
}
