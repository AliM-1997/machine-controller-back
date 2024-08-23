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
            'user_id' => 'sometimes|nullable|exists:users,id',
            'machine_id' => 'sometimes|nullable|exists:machines,id',
            'sparePart_id' => 'sometimes|nullable|exists:spare_parts,id',
            'jobDescription' => 'sometimes|nullable|string',
            'assignedDate' => 'sometimes|nullable|date',
            'dueDate' => 'sometimes|nullable|date',
            'location' => 'sometimes|nullable|string',
            'status' => 'sometimes|nullable|string',
        ];
    }
}
