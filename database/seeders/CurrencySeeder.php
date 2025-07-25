<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    protected $currencies = [
        ['name' => 'United States Dollar', 'code' => 'USD'],
        ['name' => 'Euro', 'code' => 'EUR'],
        ['name' => 'British Pound', 'code' => 'GBP'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->currencies as $currency) {
            Currency::updateOrCreate([
                'code' => $currency['code'],
            ], [
                'name' => $currency['name'],
            ]);
        }
    }
}
