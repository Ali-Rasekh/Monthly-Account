<?php

namespace App\Http\Requests;

use App\Enums\LengthEnum;
use App\Enums\TransactionTypeEnum;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'person_id' => 'required|integer',
            'transaction_type' => ['required', new EnumValue(TransactionTypeEnum::class, false)],
            'transaction_amount' => 'required|integer',
            'description' => 'nullable|string|max:' . LengthEnum::Long,
            'operation' => 'required|string|max:1',
            'jdatetime' => 'missing'
        ];
    }
}
