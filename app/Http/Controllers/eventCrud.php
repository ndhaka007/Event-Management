<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\status;
use App\event;
use Auth;
use \App\Mail\EventCreated;
use Mail;
//use Illuminate\Support\Facades\Auth;

class eventCrud extends Controller
{

    /**
     * middleware for authorization
     */
    public function __construct()
    {
        $this->middleware('basicAuth');
    }

    /**
     * to send mail
     */
    public function mailto($email,$event)
    {
        Mail::to($email)->send(
            new EventCreated($event)
        );
    }

    /**
     * Display a listing of the profile.
     */
    public function profile()
    {
        //
        $user = auth()->user();
        $profile= user::where('user_id',$user->user_id)->get();
        return $profile;

    }

    /**
     * Display a listing of the event created.
     * Depending on user or Admin.
     */
    public function eventShow()
    {
        //
        $user = auth()->user();
        if($user->role==1)
        {
            $event = event::all();
        }
        else {
            $event = event::where('user_id', $user->user_id)->get();
        }

        return $event;
    }

    /**
     * This function send the invitation and email to guest
     *
     * requires email of guest
     * requires event id for which the invitation is sent
     */
    public function invite(Request $request)
    {
        //
        $email = request('email');
        $event_id = request('event_id');

        $event = event::where('event_id',$event_id)->first();
        $this->authorize('delete', $event);

        $user=user::select('user_id')->where('email',$email)->first();

        $status = new status();

        $status->user_id = $user->user_id;
        $status->event_id = $event_id;
        $status->status = 0; //invitation
        $status->save();

        $this->mailto($email, $event);

        return "Invitation sent";
    }

    /**
     * Store a newly created event in storage.
     *
     *
     */
    public function store(Request $request)
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

    $user = auth()->user();
    $event->user_id = $user->user_id;
    $event->event_name= request('event_name');
    $event->place = request('place');
    $event->description = request('description');
    $event->start = request('start_time');
    $event->end = request('end_time');

    $event->save();
    return "Event saved";

    }

    /**
     * Display the events in which user is invited.
     *
     */
    public function showInvitation()
    {
        //
        $user = auth()->user();
        $event_id = status::where('user_id',$user->user_id)->orderBy('status','asc')->get();
        $invitation=array();
        foreach($event_id as $event){
            $ev = event::where('event_id',$event->event_id)->get()[0];
            array_push($invitation,$ev);
        }
        return $invitation;
    }

    /**
     * This function use to send reply of the invitation.
     *
     * requires event_id for which the response is given.
     * requires status of accepting(1) or rejection(2).
     *
     */
    public function replyInvitation(Request $request)
    {
        //
        $user = auth()->user();

        $event_id = request('event_id');
        $status = request('status');

        status::where('user_id',$user->user_id)->where('event_id',$event_id)->update(['status'=>$status]);
        if($status==1)return "Accepted";
        else return "rejected";

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the event from storage.
     * And send mail of event cancellation
     *
     */
    public function delete(Request $request)
    {
        //
        $id = request('id');
        $event = event::where('event_id',$id)->first();
        $this->authorize('delete', $event);

        $user_id = status::where('event_id',$id)->get();
        foreach($user_id as $user){

            $us = user::where('user_id',$user->user_id)->get()[0];
            $r="p";
            $this->mailto($us->email,$r);
        }

        $event->delete();
        return "Event deleted";
    }
}
