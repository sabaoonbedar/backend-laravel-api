<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHasSource extends Model
{
    protected $fillable = [
        'source_name',
        'source_value',
        'flag',

    ];
}
