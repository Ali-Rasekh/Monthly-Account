<?php

namespace Database\Factories;

use App\traits\JalaliTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountValue>
 */
class AccountValuesFactory extends Factory
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
            'account_id' => 1,
            'value' => 12,
            'jdatetime' => $this->getNowByDateTimeString()
        ];
    }
}
