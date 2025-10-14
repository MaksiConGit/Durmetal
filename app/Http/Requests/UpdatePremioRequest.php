<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePremioRequest extends FormRequest
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
        $premio = $this->route('premio');

        session()->put([
            'modal' => 'edit',
            'premio_id' => $premio->id,
        ]);

        return [
            'Nombre' => ['required', 'string', 'max:255'],
            'FechaDesde' => ['required', 'date'],
            'FechaHasta' => ['required', 'date', 'after_or_equal:FechaDesde'],
            'PremioTotal' => ['required', 'numeric', 'min:0'],
            'Estado' => ['required', 'in:PENDIENTE,COMPLETO'],

            'IdUsuario' => ['required', 'array'],
            'IdUsuario.*' => ['required', 'integer', 'exists:users,id'],

            'PremioBase' => ['required', 'array'],
            'PremioBase.*' => ['nullable', 'numeric', 'min:0'],

            'IndiceBase' => ['required', 'array'],
            'IndiceBase.*' => ['required', 'numeric', 'min:0'],

            'Coeficiente' => ['required', 'array'],
            'Coeficiente.*' => ['required', 'numeric', 'min:0'],

            'Premio' => ['required', 'array'],
            'Premio.*' => ['required', 'numeric', 'min:0'],
        ];
    }
}
