<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Passport\HasApiTokens;  //add the namespace

class User extends Authenticatable
{

    use HasApiTokens, Notifiable, HasRoles;

// if you want to avail log activity
// use LogsActivity

    // protected $guard_name = 'api';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'branch',
        'role',
        'contact',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function authors()
    {
        return $this->hasMany(UserHasAuthors::class,'users_id');
 
    }

    public function sources()
    {
        return $this->hasMany(UserHasSource::class,'users_id');
         
    }   

    public function categories()
    {
        return $this->hasMany(UserHasCategory::class,'users_id');
       
    }



}
