<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSparePartRequest extends FormRequest
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
            'name' => 'somtimes|string|max:255',
            'serial_number'=>'sometimes|string|max:255|unique:spare_parts',
            'quantity' => 'sometimes|nullable|numeric|min:0',
            'description' => 'sometimes|nullable|string|max:5000',
            'image_path' => 'sometimes|nullable|string|max:255',
        ];
    }
}
