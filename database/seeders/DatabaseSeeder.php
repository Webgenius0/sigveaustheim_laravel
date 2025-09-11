<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SchoolTableSeeder::class,
            SettingSeeder::class,
            CmsSeeder::class,
            StudentSeeder::class,
            FitnessTestSeeder::class,
            AgilityRuleSeeder::class,
            FlexibilityRuleSeeder::class,
            BalanceRuleSeeder::class
        ]);
    }
}
