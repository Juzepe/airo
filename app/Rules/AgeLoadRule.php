<?php

namespace App\Rules;

use App\Models\AgeLoad;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AgeLoadRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $ageLoads = AgeLoad::all();
        $ages = explode(',', $value);

        foreach ($ages as $age) {
            if (! $ageLoads->where('min_age', '<=', $age)->where('max_age', '>=', $age)->first()) {
                $fail('One of the ages is not valid.');
            }
        }
    }
}
