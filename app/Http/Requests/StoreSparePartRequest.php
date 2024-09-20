<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSparePartRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'serial_number'=>'required|string|max:255|unique:spare_Parts',
            'quantity'=>'nullable|numeric|min:0|default:0',
            'description' => 'nullable|string|max:5000',
            'image_path' => 'nullable|string|max:255',
            'life_cycle' => 'nullable|numeric|min:0|max:10000',
            'standard_temperature' => 'nullable|numeric|min:-273|max:5000',
        ];
    }
}
