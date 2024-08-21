<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMachineInputRequest extends FormRequest
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
            'machine_id'=>'required|exists:machines,id|numeric',
            'operating_time'=>'required|numeric|min:0',
            'down_time'=>'required|numeric|min:0',
            'number_of_failure'=>'required|numeric|min:0',
            'actual_output'=>'required|numeric|min:0',
        ];
    }
}
