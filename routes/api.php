<?php

use Illuminate\Http\Request;
use App\user;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//to register user
route::post('/register',function (Request $request){
    user::register($request);
    return "User created";
});
/*
|-------------------------------------
|User api
|-------------------------------------
|Here are api used by user
|
|for invitation:
|   0 = invited and pending
|   1 = accepted
|   2 = rejected
|
*/

//show profile user/admin
Route::get('/profile','eventCrud@profile');

//show created event for user/admin
Route::get('/event','eventCrud@eventShow');

//show invited events
Route::get('/events','eventCrud@showInvitation');

//store event
Route::post('/event','eventCrud@store');

//send invitation
Route::post('/invite','eventCrud@invite');

//reply to invitations
Route::patch('/invite','eventCrud@replyInvitation');

//delete event
Route::delete('/event','eventCrud@delete');



/*
|-------------------------------------
|Admin api
|-------------------------------------
|Here are api used by admin
*/

//show all user
Route::get('/user','admin@showUser');
//reply to invitations
Route::patch('/adminInvite','admin@replyInvitation');
//delete user
Route::delete('/user','admin@delete');




