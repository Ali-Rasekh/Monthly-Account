<?php

namespace App\Http\DTOs;

use App\Enums\BooleanYes;
use App\Enums\LengthEnum;
use App\Enums\TransactionTypeEnum;
use App\traits\JalaliTrait;
use BenSampo\Enum\Rules\EnumValue;
use Spatie\LaravelData\Data;

class CalculateInputDTO extends Data
{
    use JalaliTrait;

    public string $date;
    public float $shareholder_interest_percentage;
    public float $partners_percentage;
    public float $total_wealth;
    public float $total_belongings;
    public array $accounts;

    public static function rules(): array
    {
        return [
            "date" => 'required|string|max:10',
            "accounts.*" => 'required|numeric',
        ];
    }


    public function fillSystematicFields(): void
    {

    }
}
