<?php

namespace App\Http\Requests;

use App\Enums\LengthEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpsertPersonRequest extends FormRequest
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
            'name' => 'required|string|max:' . LengthEnum::Mid,
            'mobile' => 'nullable|string|max:11',
            'is_partner' => 'nullable',
        ];
    }
}
