<?php

namespace Database\Factories;

use App\traits\JalaliTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
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
            'transaction_type' => 1,
            'transaction_amount' => random_int(1000, 5000),
//            'description' =>,
            'jdatetime' => $this->getNowByDateTimeString()
        ];
    }
}
