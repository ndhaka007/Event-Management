<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class status extends Model
{
    //
    protected $fillable = [
        'user_id', 'event_id', 'status',
    ];
    public function event()
    {
        return $this->belongsTo('App\events','event_id','event_id');
    }

    public function user()
    {
        return $this->belongsTo('App\users','user_id','user_id');
    }
}
