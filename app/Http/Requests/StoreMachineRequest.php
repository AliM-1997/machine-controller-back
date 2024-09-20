<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMachineRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:machines',
            'status' => 'required|in:active,under maintenance,attention',
            'location' => 'nullable|string|max:255',
            'image_path' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'last_maintenance' => 'required|date',
            'unit_per_hour' => 'required|integer|min:0',
        ];
    }
}
