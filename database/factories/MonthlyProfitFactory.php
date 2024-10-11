<?php

namespace Database\Factories;

use App\traits\JalaliTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonthlyProfit>
 */
class MonthlyProfitFactory extends Factory
{
    use JalaliTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'person_id' => 1,
            'current_wealth' => 1,
            'current_belongings',
            'current_participation_percentage' => 1,
            'wealth_profit' => 1,
            'belongings_profit' => 1,
            'participation_profit' => 1,
            'total_profit' => 1,
            'jdatetime' => $this->getNowByDateTimeString()
        ];
    }
}
