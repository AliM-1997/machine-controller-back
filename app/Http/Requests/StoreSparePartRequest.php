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
            'serial_number'=>'required|string|max:255|unique',
            'quantity'=>'nullable|numeric|min:0|default:0',
            'description' => 'nullable|string|max:5000',
            'image_path' => 'nullable|string|max:255',
        ];
    }
}
