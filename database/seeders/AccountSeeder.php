<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::factory(11)->sequence(
            ['id' => 1, 'name' => 'موجودی کالا', 'parent_id' => null],
            ['id' => 2, 'name' => 'موجودی حساب', 'parent_id' => null],
            ['id' => 3, 'name' => 'بدهکاران', 'parent_id' => null],
            ['id' => 4, 'name' => 'بستانکاران', 'parent_id' => null],
            ['id' => 5, 'name' => 'موجودی نقدی', 'parent_id' => 2],
            ['id' => 6, 'name' => 'بانک ملت', 'parent_id' => 2],
            ['id' => 7, 'name' => 'بانک ایران', 'parent_id' => 2],
            ['id' => 8, 'name' => 'بانک مهر', 'parent_id' => 2],
            ['id' => 9, 'name' => 'چک های دریافتی', 'parent_id' => 2],
            ['id' => 10, 'name' => 'حساب های بستانکار', 'parent_id' => 4],
            ['id' => 11, 'name' => 'چک های پرداختی', 'parent_id' => 4],
        )->create();
    }
}
