<?php

namespace App\Http\Requests;

use App\Enums\LengthEnum;
use Illuminate\Foundation\Http\FormRequest;

class SetPartnersPercentageRequest extends FormRequest
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
            'partner' => 'required|array',
            'partner.*' => 'required|integer',
        ];
    }
}
