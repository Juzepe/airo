<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quotation>
 */
class QuotationFactory extends Factory
{
    protected $model = Quotation::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $endDate = (clone $startDate)->modify('+'.rand(1, 30).' days');

        return [
            'user_id' => User::factory(),
            'currency_id' => Currency::factory(),
            'age' => $this->faker->numberBetween(18, 65),
            'total' => $this->faker->randomFloat(2, 100, 10000),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ];
    }
}
