<?php

namespace Database\Seeders;

use App\Models\AgeLoad;
use Illuminate\Database\Seeder;

class AgeLoadSeeder extends Seeder
{
    protected $ageLoads = [
        ['min_age' => 18, 'max_age' => 30, 'load' => 0.6],
        ['min_age' => 31, 'max_age' => 40, 'load' => 0.7],
        ['min_age' => 41, 'max_age' => 50, 'load' => 0.8],
        ['min_age' => 51, 'max_age' => 60, 'load' => 0.9],
        ['min_age' => 61, 'max_age' => 70, 'load' => 1.0],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->ageLoads as $ageLoad) {
            AgeLoad::updateOrCreate([
                'min_age' => $ageLoad['min_age'],
                'max_age' => $ageLoad['max_age'],
            ], [
                'load' => $ageLoad['load'],
            ]);
        }
    }
}
