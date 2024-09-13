<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSparePartRequest extends FormRequest
{
    public function authorize()
    {
        // Add authorization logic if needed
        return true;
    }

    public function rules(): array
    {
        $sparePartId = $this->route('sparePart');

        return [
            'name' => 'sometimes|string|max:255',
            'serial_number' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('spare_parts')->ignore($sparePartId),
            ],
            'quantity' => 'sometimes|nullable|numeric|min:0',
            'description' => 'sometimes|nullable|string|max:5000',
            'image_path' => 'sometimes|nullable|string|max:255',
            'type' => 'sometimes|required|in:Mechanical,Electrical,Oil',
            'life_cycle' => 'sometimes|nullable|numeric|min:0',
            'standard_temperature' => 'sometimes|nullable|numeric|min:0',
        ];
    }
}
