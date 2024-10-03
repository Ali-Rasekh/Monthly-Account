<?php

namespace Database\Factories;

use App\traits\JalaliTrait;
use Illuminate\Database\Eloquent\Factories\Factory;
use Morilog\Jalali\Jalalian;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    use JalaliTrait;
    public function definition(): array
    {
        //should sum = 100
        return [
            'Shareholder_interest_percentage' => 33.5,
            'partners_percentage' => 66.5,
            'jdatetime' => $this->getNowByDateTimeString()
        ];
    }
}
