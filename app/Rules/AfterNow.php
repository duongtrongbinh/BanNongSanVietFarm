<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;


class AfterNow implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // So sánh giá trị với ngày và giờ hiện tại
        return strtotime($value) > time();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a date after the current date and time.';
    }
}
