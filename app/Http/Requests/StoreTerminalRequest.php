<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTerminalRequest extends FormRequest
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
            'NombreHost'          => 'required|string|max:255',
            'IdImpresoraFiscal'   => 'nullable|integer|exists:impresora_fiscal,id',
            'NombreEtiquetadora'  => 'required|string|max:255',
        ];
    }
}
