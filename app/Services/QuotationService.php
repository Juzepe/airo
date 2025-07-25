<?php

namespace App\Services;

use App\DTOs\CalculateQuotationTotalDTO;
use App\Exceptions\AgeLoadException;
use App\Models\AgeLoad;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class QuotationService
{
    private Collection $ages;

    public function __construct()
    {
        $this->ages = AgeLoad::all();
    }

    public function calculateTotal(CalculateQuotationTotalDTO $dto): float
    {
        $ages = explode(',', $dto->age);
        $tripLength = Carbon::parse($dto->start_date)->diffInDays(Carbon::parse($dto->end_date)) + 1;

        $total = array_reduce($ages, function ($carry, $age) use ($tripLength) {
            $ageLoad = $this->ages->where('min_age', '<=', $age)->where('max_age', '>=', $age)->first();

            if (! $ageLoad) {
                throw new AgeLoadException;
            }

            $rate = config('app.quotations.fixed_rate');

            return $carry + $rate * $ageLoad->load * $tripLength;
        }, 0);

        return round($total, 2);
    }
}
