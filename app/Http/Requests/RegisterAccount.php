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
        return [
            'first_name' => "required|string",
            'middle_name' => "nullable",
            'last_name' => "required|string",
            'image' => "nullable",
            'phone' => "required|unique:users,phone|digits:11",
            'email' => "required|unique:users,email|email:rfc,dns",
            'password' => "required|min:8",
            'confirm_password' => "required|same:password|min:8",
            'user_type' => "required",
            'perspective' => "required",
            'is_active' => "required",
        ];
    }
}
