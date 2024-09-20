<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMachineStatisticRequest extends FormRequest
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
            'machine_id' => 'required|exists:machines,id',
            'MTTR' => 'required|numeric|min:0',
            'MTBF' => 'required|numeric|min:0',
            'availability' => 'required|numeric|min:0|max:100',
            'upTime' => 'required|numeric|min:0',
            'efficiency' => 'required|numeric|min:0|max:100',
            'date' => 'required|date',
        ];
    }
}
