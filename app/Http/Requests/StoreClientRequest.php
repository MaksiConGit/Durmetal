<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'id' => 'required|integer|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,id',
            'phone' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'client_qualification_id' => 'required|integer|exists:client_qualifications,id',
            'iva_condition_id' => 'required|integer|exists:iva_conditions,id',
            'document_type_id' => 'required|integer|exists:document_types,id',
            'document_number' => 'required|integer',
            'balance' => 'required|integer',
            'emails' => 'nullable|array|max:6',
            'emails.*' => 'nullable|email|max:255',
        ];
    }
}
