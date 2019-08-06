<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\status;
use App\event;
use Auth;

class admin extends Controller
{
    public function __construct()
    {
        $this->middleware('basicAuth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUser()
    {
        //
        $admin = auth()->user();
        if($admin->role==1) {
            $user = user::all();
            return $user;
        }
        else{
            return response()->json(['message'=>'Auth Failed'],401);
        }
    }

    /**
     * This function use to send reply of the invitation.
     *
     * requires guest id.
     * requires event_id for which the response is given.
     * requires status of accepting(1) or rejection(2).
     *
     */
    public function replyInvitation(Request $request)
    {
        //
        $admin = auth()->user();

        if($admin->role==1) {
            $user_id = request('user_id');
            $event_id = request('event_id');
            $status = request('status');

            status::where('user_id',$user_id)->where('event_id',$event_id)->update(['status'=>$status]);
            if($status==1)return "Accepted";
            else return "rejected";
        }
        else{
            return response()->json(['message'=>'Auth Failed'],401);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete()
    {
        //

        $admin = auth()->user();
        if($admin->role==1) {

            $id = request('id');
            $user = user::where('user_id',$id)->first();

            $user->delete();
            return "user deleted";

        }
        else{
            return response()->json(['message'=>'Auth Failed'],401);
        }

    }
}
