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
            'user_id' => 'sometimes|required|exists:users,id',
            'machine_id' => 'sometimes|required|exists:machines,id',
            'sparePart_id' => 'nullable|exists:spare_parts,id',
            'jobDescription' => 'sometimes|required|string',
            'assignedDate' => 'sometimes|required|date',
            'dueDate' => 'sometimes|required|date',
            'location' => 'sometimes|required|string',
            'status' => 'sometimes|required|string',
        ];
    }

    /**
     * Customize the validation messages (optional).
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user ID is invalid.',
            'machine_id.required' => 'The machine ID is required.',
            'machine_id.exists' => 'The selected machine ID is invalid.',
        ];
    }
}
