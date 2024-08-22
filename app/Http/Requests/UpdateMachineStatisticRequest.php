<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMachineStatisticRequest extends FormRequest
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
            'machine_id' => 'sometimes|required|exists:machines,id',
            'MTTR' => 'sometimes|numeric|min:0',
            'MTBF' => 'sometimes|numeric|min:0',
            'availability' => 'sometimes|numeric|min:0|max:1',
            'upTime' => 'sometimes|numeric|min:0',
            'efficiency' => 'sometimes|numeric|min:0|max:100',
            'date' => 'sometimes|date',
        ];
    }
}
