<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return false;
    }

    public function rules($editURL, $userId)
    {
       $rules = [
            'firstName' => 'required|min:3',
            'lastName' => 'required|min:3',
            'roleId' => 'required',
            'passwordConfirm' => 'same:password'
        ];

        // checks if the url is for update an user
        if ($editURL) {
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ];
            $rules['password'] = 'nullable|min:8';
        }
        else {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|min:8';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'firstName.required' => 'The First Name field is required.',
            'firstName.min' => 'The First Name must be at least :min characters.',
            'lastName.required' => 'The Last Name field is required.',
            'lastName.min' => 'The Last Name must be at least :min characters.',
            'roleId.required' => 'The Role field is required.',
            'email.required' => 'The Email Address field is required.',
            'email.email' => 'The Email Address format is not valid.',
            'email.unique' => 'This Email Address is already in use.',
            'password.required' => 'The Password field is required.',
            'password.min' => 'The Password must be at least :min characters.',
            'passwordConfirm.same' => 'The Password Confirmation must match the Password.'
        ];
    }
}
