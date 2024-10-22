<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create();
        Setting::factory()->create();
        Person::factory(1)->sequence([
            'name' => 'ایمان', 'wealth' => 50, 'belongings' => 30, 'is_partner' => 1, 'percentage_of_participation' => 100],
//            ['name' => 'moosa', 'wealth' => 50, 'belongings' => 30, 'is_partner' => 1, 'percentage_of_participation' => 1]
        )->create();
    }
}
