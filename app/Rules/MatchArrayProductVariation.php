<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchArrayProductVariation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        

        $data = request();

        // check Required field
        // $requiredFields = [
        //     'variant_image',
        //     'color_id',
        //     'size_id',
        //     'total_stock',
        //     'sku',
        //     'sku_threshold_value',
        //     'actual_price',
        //     'discount_type',
        //     'discount_value',
        //     'final_price'
        // ];
    
        // foreach ($requiredFields as $field) {
        //     if (!$data->has($field) || empty($data->$field)) {
        //          $fail(strtoupper(str_replace('_', ' ', $field)) . ' field is required.');
        //     }
        // }




        $count1 = count($data->variant_image ?? []);
        $count2 = count($data->color_id ?? []);
        $count3 = count($data->size_id ?? []);
        $count4 = count($data->total_stock ?? []);
        $count5 = count($data->sku ?? []);
        $count6 = count($data->sku_threshold_value ?? []);
        $count7 = count($data->actual_price ?? []);
        $count8 = count($data->discount_type ?? []);
        $count9 = count($data->discount_value ?? []);
        $count10 = count($data->final_price ?? []);


        if (!($count1 === $count2 && $count1 === $count3 && $count1 === $count4 && 
        $count1 === $count5 && 
        $count1 === $count6 && 
        $count1 === $count7 && 
        $count1 === $count8 && 
        $count1 === $count9 && 
        $count1 === $count10 
        )) {
            $fail('All product Variation arrays must contain the same number of items.');
        }

    }
}