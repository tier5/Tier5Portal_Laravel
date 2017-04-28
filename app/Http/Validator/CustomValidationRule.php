<?php

namespace App\Http\Validator;

class CustomValidationRule extends \Illuminate\Validation\Validator
{
    public function validateMonthYear($attribute, $value, $parameters)
    {
        // Can have 3 letter month name as string followed by 4 letter year
        // number.
        return preg_match("/^(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sept|Oct|Nov|Dec)[0-9]{4}$/i", $value);
    }
}