<?php

namespace App\Http\DTOs;

use App\Enums\BooleanYes;
use App\Enums\LengthEnum;
use App\Enums\TransactionTypeEnum;
use App\traits\JalaliTrait;
use BenSampo\Enum\Rules\EnumValue;
use Spatie\LaravelData\Data;

class StoreAccountValuesInputDTO extends Data
{
    public array $insertData;


    public static function rules(): array
    {
        $insert = 'insertData.*.';
        return [
            "$insert.account_id" => 'required|string|max:100',
            "$insert.value" => 'required|numeric',
            "$insert.jdatetime" => 'required|string|max:10',
            "$insert.created_at" => 'required',
        ];
    }


    public function fillSystematicFields(): void
    {

    }
}
