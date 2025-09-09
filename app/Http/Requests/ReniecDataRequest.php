<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReniecDataRequest extends FormRequest
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
            'document_number' => 'required|string|max:20',
            'paternal_last_name' => 'nullable|string|max:50',
            'maternal_last_name' => 'nullable|string|max:50',
            'name' => 'nullable|string|max:50',
            'cod_verificacion' => 'nullable|string',
            'gender' => 'nullable|string|max:1',
            'date_of_birth' => 'nullable|date',
            'date_of_death' => 'nullable|date',
            'department' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'marital_status' => 'nullable|string|max:20',
            'education_level' => 'nullable|string|max:50',
            'height' => 'nullable|numeric',
            'registration_date' => 'nullable|date',
            'issue_date' => 'nullable|date',
            'expiration_date' => 'nullable|date',
            'father' => 'nullable|string|max:150',
            'mother' => 'nullable|string|max:150',
            'restrictions' => 'nullable|string',
            'address' => 'nullable|string',
            'ubigeo_reniec' => 'nullable|string|max:10',
            'ubigeo_inei' => 'nullable|string|max:10',
            'ubigeo_sunat' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'photo' => 'nullable|string',
        ];
    }
}
