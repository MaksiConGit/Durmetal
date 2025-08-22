<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConversorDurezaRequest extends FormRequest
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
            'ValorHB'   => 'required|integer|min:0',
            'ValorHRC'  => 'required|integer|min:0',
            'ValorKMM2' => 'required|integer|min:0',
            'ValorMPA'  => 'required|integer|min:0',
            'ValorKSI'  => 'required|integer|min:0',
        ];
    }
}
