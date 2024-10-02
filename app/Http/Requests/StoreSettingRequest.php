<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
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
            'Shareholder_interest_percentage' => 'required|numeric|min:0|max:100',
            'partners_percentage' => 'required|numeric|min:0|max:100',
//            'each_partner_percent' => 'required|array',
//            'each_partner_percent.*' => 'required|numeric|min:0|max:100',
        ];
    }
}
