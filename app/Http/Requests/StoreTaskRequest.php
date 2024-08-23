<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'machine_id' => 'required|exists:machines,id',
            'sparePart_id' => 'nullable|exists:spare_parts,id',
            'jobDescription' => 'required|string',
            'assignedDate' => 'required|date',
            'dueDate' => 'required|date',
            'location' => 'required|string',
            'status' => 'required|string',
        ];
    }
}
