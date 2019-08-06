<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class user extends Authenticatable
{
    //
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_name', 'password', 'email', 'role',
    ];

    public function event()
    {
        return $this->hasMany('App\events','user_id','user_id');
    }

    public function status()
    {
        return $this->hasMany('App\statuses','use_id','user_id');
    }
}
