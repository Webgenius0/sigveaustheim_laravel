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
            SchoolTableSeeder::class,
            UserSeeder::class,
            SettingSeeder::class,
            CmsSeeder::class,
            StudentSeeder::class,
            FitnessTestSeeder::class,
            AgilitySeeder::class,
            FlexibilitySeeder::class
        ]);
    }
}
