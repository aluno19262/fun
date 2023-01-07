<?php

namespace App\Models\Policies;

use App\Models\Associate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssociatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
        return $user->can('manageApp') || $user->can('accessAsCAC');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Associate $associate)
    {
        return $user->can('manageApp') || $associate->user_id == $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('manageApp');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Associate $associate)
    {
        return $user->can('manageApp') || $user->can('accessAsCAC') ||  $associate->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Associate $associate)
    {
        return $user->can('manageApp');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Associate $associate)
    {
        return $user->can('manageApp');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Associate $associate)
    {
        return $user->can('manageApp');
    }

    public function evaluations(User $user, Associate $associate)
    {
        return $user->can('accessAsCAC') || $user->can('manageApp');
    }

    public function inEvaluationIndex(User $user, Associate $associate){
        return $user->can('accessAsCAC') || $user->can('manageApp');
    }
}
