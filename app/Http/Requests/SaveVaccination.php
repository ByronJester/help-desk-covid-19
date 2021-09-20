<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveVaccination extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'place_id' => "required",
            'vaccine_id' => "required",
            'name' => "required",
            'age' => "required|numeric",
            'birth_date' => "required",
            'phone' => "required|numeric",
            'gender' => "required",
            'classification' => "required"
        ];

        return $rules;
    }
}
