<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\AutoFile;

class FileUniqueValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $valueFile=$value->getClientOriginalName();


        $fileName = AutoFile::where('file_name', '=', $valueFile)->first();
if($fileName===null){
return false;

}else{
    return true;


}


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
        //
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
