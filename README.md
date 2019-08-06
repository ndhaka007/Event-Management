# Event-Management

//to register user <br />
route::post('/register',function (Request $request){});<br />

/*
|-------------------------------------
|User api
|-------------------------------------
|Here are api used by user
|for invitation:
|   0 = invited and pending
|   1 = accepted
|   2 = rejected
*/

//show profile user/admin<br />
Route::get('/profile','eventCrud@profile');<br />

//show created event for user/admin<br />
Route::get('/event','eventCrud@eventShow');<br />

//show invited events<br />
Route::get('/events','eventCrud@showInvitation');<br />

//store event<br />
Route::post('/event','eventCrud@store');<br />

//send invitation<br />
Route::post('/invite','eventCrud@invite');<br />

//reply to invitations<br />
Route::patch('/invite','eventCrud@replyInvitation');<br />

//delete event<br />
Route::delete('/event','eventCrud@delete');<br />

/*
|-------------------------------------
|Admin api
|-------------------------------------
|Here are api used by admin
*/

//show all user<br />
Route::get('/user','admin@showUser');<br />
//reply to invitations<br />
Route::patch('/adminInvite','admin@replyInvitation');<br />
//delete user<br />
Route::delete('/user','admin@delete');<br />
