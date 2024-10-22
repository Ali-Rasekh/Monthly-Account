<?php

namespace App\Http\DTOs;

use App\Enums\BooleanYes;
use App\Enums\LengthEnum;
use App\Enums\TransactionTypeEnum;
use App\traits\JalaliTrait;
use BenSampo\Enum\Rules\EnumValue;
use Spatie\LaravelData\Data;

class StoreMonthlyProfitsInputDTO extends Data
{
   public array $accountValues_table;

    public static function rules(): array
    {
        return [
                'accountValuesTable' => 'required|array', // بررسی وجود و آرایه بودن
                'accountValuesTable.*.account_name' => 'required|string|max:100', // ولیدیشن فیلدهای درون آرایه
                'accountValuesTable.*.value' => 'required|numeric', // مقدار عددی برای هر حساب
                'accountValuesTable.*.jdatetime' => 'required|string|max:10', // تاریخ معتبر

                'monthlyProfitsTable' => 'required|array',
                'monthlyProfitsTable.*.name' => 'required|string|max:100',
                'monthlyProfitsTable.*.current_wealth' => 'required|numeric',
                'monthlyProfitsTable.*.current_belongings' => 'required|numeric',
                'monthlyProfitsTable.*.current_participation_percentage' => 'required|numeric|min:0|max:100',
                'monthlyProfitsTable.*.wealth_profit' => 'required|numeric',
                'monthlyProfitsTable.*.belongings_profit' => 'required|numeric',
                'monthlyProfitsTable.*.participation_profit' => 'required|numeric',
                'monthlyProfitsTable.*.total_profit' => 'required|numeric',
                'monthlyProfitsTable.*.jdatetime' => 'required|string|max:10', // تاریخ معتبر
        ];
    }


    public function fillSystematicFields(): void
    {

    }
}
