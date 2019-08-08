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
        if($user->role)
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

        $event = event::where('event_id',$request['event_id'])->first();
        $this->authorize('delete', $event);
        status::sendInvite($request);

        return "Invitation sent";
    }

    /**
     * Store a newly created event in storage.
     *
     *
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        event::storeEvent($request,$user->user_id);
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
        $user = auth()->user();
        return status::replyInvite($request,$user->user_id);
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
        $event = event::where('event_id',$request['id'])->first();
        $this->authorize('delete', $event);

        $user_id = status::where('event_id',$request['id'])->get();
        foreach($user_id as $user){

            $us = user::where('user_id',$user->user_id)->get()[0];
            $r="Event Cancelled";
            $this->mailto($us->email,$r);
        }

        $event->delete();
        return "Event deleted";
    }
}
