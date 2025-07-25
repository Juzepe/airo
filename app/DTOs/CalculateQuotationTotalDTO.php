<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class CalculateQuotationTotalDTO extends Data
{
    public function __construct(
        public string $age,
        public string $start_date,
        public string $end_date,
    ) {}
}
