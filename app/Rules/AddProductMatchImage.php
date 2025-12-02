<?php
// app/Rules/MatchArrayProductSpecification.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AddProductMatchImage implements Rule
{
    protected $colorKey;
    protected $imageKey;

    public function __construct($colorKey, $imageKey)
    {
        $this->colorKey = $colorKey;
        $this->imageKey = $imageKey;
    }

    public function passes($attribute, $value)
    {
        $colors = request()->input($this->colorKey, []);
        $images = request()->input($this->imageKey, []);

        // If colors exist, enforce matching structure
        if (!empty($colors)) {
            // Check array count
            if (count($colors) !== count($images)) {
                return false;
            }

            // Check each color index has image index
            foreach ($colors as $index => $color) {
                if (!isset($images[$index])) {
                    return false;
                }
            }
        }

        return true;
    }

    public function message()
    {
        return 'Color and image array must have same structure and indexes.';
    }
}