<?php

namespace App\Rules;

use Dotenv\Regex\Regex;
use Illuminate\Contracts\Validation\Rule;

class ContactValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        $isSlugExist= User::where('slug', $value)->exists();

        if(preg_match("/\+([0-9][0-9])(\-)[0-9]{9}$/",$value)){
return true;
        }else{
return false;

        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The number must be +xx-xxxxxxxxx e.g. +93-893748923 ';
    }
}
