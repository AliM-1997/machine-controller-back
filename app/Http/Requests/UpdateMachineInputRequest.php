<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMachineInputRequest extends FormRequest
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
            'machine_id'=>'sometimes|exists:machines,id|numeric',
            'operating_time'=>'sometimes|numeric|min:0',
            'down_time'=>'sometimes|numeric|min:0',
            'number_of_failure'=>'sometimes|numeric|min:0',
            'actual_output'=>'sometimes|numeric|min:0',
        ];
    }
}
