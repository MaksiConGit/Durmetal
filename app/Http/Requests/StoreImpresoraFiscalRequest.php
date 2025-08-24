<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImpresoraFiscalRequest extends FormRequest
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
            'Nombre'              => 'required|string|max:255',
            'Modelo'              => 'required|string|max:255',
            'PuertoCOM'           => 'required|integer|min:0',
            'VelocidadPrEpson'    => 'required|integer|min:0',
            'TipoProtocoloPrEpson'=> 'required|integer|min:0',
        ];
    }
}
