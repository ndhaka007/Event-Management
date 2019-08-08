<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    public static function storeEvent(request $request, $id)
    {
        //to validate event data
        $validatedData = $request->validate([
            'event_name' => 'required',
            'place' => 'required',
            'description' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $event = new event();

        $event->user_id = $id;
        $event->event_name= $request['event_name'];
        $event->place = $request['place'];
        $event->description = $request['description'];
        $event->start = $request['start_time'];
        $event->end = $request['end_time'];

        $event->save();
    }
}
