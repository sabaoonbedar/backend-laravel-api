<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHasCategory extends Model
{
    protected $fillable = [
        'catagory_name',
        'catagory_value',
        'flag',

    ];
}
