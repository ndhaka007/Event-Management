<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    //
    protected $primaryKey = 'event_id';
    protected $fillable = [
        'user_id', 'event_name', 'place', 'description', 'start', 'end',
    ];
    public function user()
    {
        return $this->belongsTo('App\users','user_id','user_id');
    }

    public function status()
    {
        return $this->hasMany('App\statuses','event_id','event_id');
    }
}
