<?php

namespace Database\Seeders;

use App\Models\FitnessTests;
use Illuminate\Database\Seeder;

class FitnessTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tests = [
            [
                'name' => 'AGILITY',
                'description' => 'Measure how quickly you can change direction',
                'scoring_type' => 'seconds'
            ],
            [
                'name' => 'FLEXIBILITY',
                'description' => 'Measure range of motion in joints',
                'scoring_type' => 'cm'
            ],
            [
                'name' => 'BALANCE',
                'description' => 'Measure ability to maintain equilibrium',
                'scoring_type' => 'seconds'
            ],
            [
                'name' => 'COORDINATION',
                'description' => 'Assess motor coordination skills',
                'scoring_type' => 'times'
            ],
            [
                'name' => 'REACTION',
                'description' => 'Measure response time to stimuli',
                'scoring_type' => 'cm'
            ],
            [
                'name' => 'POWER',
                'description' => 'Measure explosive strength',
                'scoring_type' => 'cm'
            ],
            [
                'name' => 'MUSCLE STRENGTH',
                'description' => 'Measure maximum force production',
                'scoring_type' => 'kg'
            ],
            [
                'name' => 'MUSCLE STAMINA',
                'description' => 'Measure muscular endurance',
                'scoring_type' => 'seconds'
            ],
            [
                'name' => 'SPEED',
                'description' => 'Measure how quickly you can move',
                'scoring_type' => 'seconds'
            ],
            [
                'name' => 'CARDIOVASCULAR ENDURANCE',
                'description' => 'Measure heart and lung endurance',
                'scoring_type' => 'lavels'
            ]
        ];

        foreach ($tests as $test) {
            FitnessTests::create($test);
        }
    }
}
