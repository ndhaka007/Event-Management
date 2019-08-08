<?php

namespace App;

use App\Mail\EventCreated;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Mail;

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

    public function mailto($email,$event)
    {
        Mail::to($email)->send(
            new EventCreated($event)
        );
    }


    public static function sendInvite(request $request)
    {
        $user=user::select('user_id')->where('email',$request['email'])->first();

        $status = new status();

        $status->user_id = $user->user_id;
        $status->event_id = $request['event_id'];
        $status->status = 0; //invitation
        $status->save();

        $status->mailto($request['email'], "Event Invite");
    }

    public static function replyInvite(request $request,$id)
    {
        status::where('user_id',$id)->where('event_id',$request['event_id'])->update(['status'=>$request['status']]);
        if($request['status']==1)return "Accepted";
        else return "rejected";
    }

}
