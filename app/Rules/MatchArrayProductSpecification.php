<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchArrayProductSpecification implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

     public function validate(string $attribute, mixed $value, Closure $fail): void
     {
        
    $data = request();

    $count1 = count($data->product_spe_en ?? []);
    $count2 = count($data->product_spe_feature_en ?? []);
    $count3 = count($data->product_spe_ar ?? []);
    $count4 = count($data->product_spe_feature_ar ?? []);

    if (!($count1 === $count2 && $count1 === $count3 && $count1 === $count4)) {
        $fail('All product specification arrays must contain the same number of items.');
    }

}

public function message()
{
    return 'All specification fields must have the same number of elements.';
}


    }
// }