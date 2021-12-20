<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VirusCase extends FormRequest
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
            'code' => "required|unique:virus_cases,code",
            'age' => "required|numeric",
            'symptom' => "required",
            'gender' => "required",
            'date' => "required",
            'travel_history' => "nullable",
            'status' => "required"
        ];

        if($this->id) {
            $rules['code'] = "required|unique:virus_cases,code," . $this->id;
        }

        return $rules;
    }
}
