<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust this if authorization is needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'sometimes|exists:users,username',
            'machine_serial_number' => 'sometimes|exists:machines,serial_number',
            'spare_part_serial_number' => 'sometimes|exists:spare_parts,serial_number',
            'jobDescription' => 'sometimes|nullable|string',
            'assignedDate' => 'sometimes|nullable|date',
            'dueDate' => 'sometimes|nullable|date',
            'location' => 'sometimes|nullable|string',
            'status' => 'sometimes|nullable|string',
        ];
        
    }
}
