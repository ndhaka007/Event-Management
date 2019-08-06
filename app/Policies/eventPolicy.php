<?php

namespace App\Policies;

use App\user;
use App\event;
use Illuminate\Auth\Access\HandlesAuthorization;

class eventPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any events.
     *
     * @param  \App\user  $user
     * @return mixed
     */
    public function viewAny(user $user)
    {
        //
    }

    /**
     * Determine whether the user can view the event.
     *
     * @param  \App\user  $user
     * @param  \App\event  $event
     * @return mixed
     */
    public function view(user $user, event $event)
    {
        //
    }

    /**
     * Determine whether the user can create events.
     *
     * @param  \App\user  $user
     * @return mixed
     */
    public function create(user $user)
    {
        //
    }

    /**
     * Determine whether the user can update the event.
     *
     * @param  \App\user  $user
     * @param  \App\event  $event
     * @return mixed
     */
    public function update(user $user, event $event)
    {
        //
    }

    /**
     * Determine whether the user can delete the event.
     *
     * @param  \App\user  $user
     * @param  \App\event  $event
     * @return mixed
     */
    public function delete(user $user, event $event)
    {
        //
        return $user->user_id === $event->user_id;
    }

    /**
     * Determine whether the user can restore the event.
     *
     * @param  \App\user  $user
     * @param  \App\event  $event
     * @return mixed
     */
    public function restore(user $user, event $event)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the event.
     *
     * @param  \App\user  $user
     * @param  \App\event  $event
     * @return mixed
     */
    public function forceDelete(user $user, event $event)
    {
        //
    }
}
