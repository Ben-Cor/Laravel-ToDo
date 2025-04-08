<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->isMethod('put')) {
            return [
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ];
        }
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
