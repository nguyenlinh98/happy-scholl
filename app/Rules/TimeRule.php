<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TimeRule implements Rule
{
    protected  $carrying_to;
    protected $carrying_from;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->carrying_from = strtotime($data['carrying_from_datetime'] . ' '.$data['carrying_from_datetime_hour']);
        $this->carrying_to = strtotime($data['carrying_to_datetime'].''. $data['carrying_to_datetime_hour']);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->carrying_from >= $this->carrying_to)
        {
//            dd($this->carrying_from, $this->carrying_to);
           return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Time period is error. Please enter the data again.';
    }
}
