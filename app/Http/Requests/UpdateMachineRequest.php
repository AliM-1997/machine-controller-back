<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Add this import

class UpdateMachineRequest extends FormRequest
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
        $machineId = $this->route('machine'); 

        return [
            'name' => 'sometimes|required|string|max:255',
            'serial_number' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('machines')->ignore($machineId)
            ],
            'status' => 'sometimes|required|in:active,under maintenance,attention',
            'location' => 'nullable|string|max:255',
            'image_path' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'last_maintenance' => 'sometimes|date',
            'unit_per_hour' => 'sometimes|integer|min:0',
        ];
    }
}
