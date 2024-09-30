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
        Person::factory()->create(['name' => 'iman', 'wealth' => 50, 'belongings' => 30, 'percentage_of_participation' => 99]);
        Person::factory()->create(['name' => 'moosa', 'wealth' => 50, 'belongings' => 30, 'percentage_of_participation' => 1]);
    }
}
