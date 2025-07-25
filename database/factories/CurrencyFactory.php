<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Currency>
 */
class CurrencyFactory extends Factory
{
    private array $currencies = [
        ['name' => 'United States Dollar', 'code' => 'USD'],
        ['name' => 'Euro', 'code' => 'EUR'],
        ['name' => 'British Pound', 'code' => 'GBP'],
    ];

    protected $model = Currency::class;

    public function definition(): array
    {
        $currency = $this->faker->randomElement($this->currencies);

        return [
            'name' => $currency['name'],
            'code' => $currency['code'],
        ];
    }
}
