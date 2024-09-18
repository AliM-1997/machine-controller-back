<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class getStaticByDateRequest extends FormRequest
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
            'date'=>'nullable|date',
            "startDate"=>'nullable|date',
            "endDate"=>'nullable|after_or_equal:startDate'
        ];
    }
        /**
     * Customize the error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'end_date.after_or_equal' => 'The end date must be a date after or equal to the start date.',
        ];
    }
}
