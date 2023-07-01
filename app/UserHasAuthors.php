<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHasAuthors extends Model
{
    protected $fillable = [
        'author_name',
        'author_value',
        'flag',

    ];
}
