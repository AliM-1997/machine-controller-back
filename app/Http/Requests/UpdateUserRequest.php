<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userID=$this->user()->id;
        return [
            'name' => 'sometimes|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,'.$userID,
            'email' => 'sometimes|string|email|max:255|unique:users,email,'.$userID,
            'phone_number' => 'nullable|string|max:20|unique:users,phone_number,' . $userID,
            'role' => 'nullable|in:admin,user',
            'password' => 'somtimes|string|min:8|confirmed', 
            'location' => 'nullable|string|max:255',
        ];
    }
}
