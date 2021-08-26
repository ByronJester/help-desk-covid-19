<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterAccount extends FormRequest
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
            'first_name' => "required|string",
            'middle_name' => "nullable",
            'last_name' => "required|string",
            'image' => "sometimes|nullable",
            'phone' => "required|unique:users,phone|digits:11",
            'email' => "required|unique:users,email|email:rfc,dns",
            'password' => "sometimes|required|min:8",
            'confirm_password' => "sometimes|required|same:password|min:8",
            'user_type' => "sometimes|required",
            'perspective' => "sometimes|required",
            'is_active' => "required",
        ];

        if($this->id) {
            $rules['phone'] = "required|unique:users,phone," . $this->id;
            $rules['email'] = "required|unique:users,email," . $this->id;
        }

        return $rules;
    }
}
