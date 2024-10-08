<?php

namespace App\Http\DTOs;

use App\Enums\BooleanYes;
use App\Enums\LengthEnum;
use App\Enums\TransactionTypeEnum;
use App\traits\JalaliTrait;
use BenSampo\Enum\Rules\EnumValue;
use Spatie\LaravelData\Data;

class CreateTransactionDTO extends Data
{
    use JalaliTrait;

    public int $person_id;
    public int $transaction_type = TransactionTypeEnum::wealth;
    public int $transaction_amount;
    public ?string $description;
    public ?string $operation = '+';
    public ?string $jdatetime;

    public static function rules(): array
    {
        return [
            'transaction_type' => ['required', new EnumValue(TransactionTypeEnum::class, false)],
            'transaction_amount' => 'required|integer',
            'description' => 'nullable|string|max:' . LengthEnum::Long,
            'operation' => 'nullable|string|max:1',
            'jdatetime' => 'missing'
        ];
    }


    public function fillSystematicFields(): void
    {
        $this->jdatetime = $this->getNowByDateTimeString();
        if ($this->operation == '-') {
            $this->transaction_amount = -abs($this->transaction_amount);
        } elseif ($this->operation == '+') {
            $this->transaction_amount = abs($this->transaction_amount);
        }

        unset($this->operation);
    }
}
