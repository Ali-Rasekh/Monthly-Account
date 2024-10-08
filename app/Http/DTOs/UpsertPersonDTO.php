<?php

namespace App\Http\DTOs;

use App\Enums\BooleanYes;
use App\Enums\LengthEnum;
use Spatie\LaravelData\Data;

class UpsertPersonDTO extends Data
{
    public string $name;
    public ?string $mobile;
    public string|int $is_partner = BooleanYes::No;

    public static function rules(): array
    {
        return [
            'name' => 'required|string|max:' . LengthEnum::Mid,
            'mobile' => 'nullable|numeric|digits:11',
            'is_partner' => 'nullable',
        ];
    }


    public function fillSystematicFields(): void
    {
        if ($this->is_partner == 'on') $this->is_partner = 1;
    }
}
