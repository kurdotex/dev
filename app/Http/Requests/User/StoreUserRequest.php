<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string|max:15|regex:/^\d+$/|unique:users,phone_number',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'email.unique' => 'The email is already taken by another user.',
            'phone_number.unique' => 'The phone number is already taken by another user.',
        ];
    }
}
