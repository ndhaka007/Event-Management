<?php

namespace App;

use Illuminate\Http\Request;
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

    public static function register(request $request)
    {
        //to validate user data
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email',
        ]);

        // to create user
        $user = new user();
        $user->user_name = $request['username'];
        $user->password	= bcrypt($request['password']);
        $user->email = $request['email'];
        $user->role = 0;
        $user->save();
    }

}
