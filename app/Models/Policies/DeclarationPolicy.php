<?php

namespace App\Models\Policies;

use App\Models\Declaration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class DeclarationPolicy
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
        return !$user->canAny('accessAsUser') || (!empty(\Illuminate\Support\Facades\Request::all()['associate_id']) && \Illuminate\Support\Facades\Request::all()['associate_id'] == $user->associate->id);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Declaration  $declaration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Declaration $declaration)
    {
        return !$user->canAny('accessAsUser') || ($declaration->associate->id == $user->associate->id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('manageApp') || (!empty($user->associate) && !empty(\request()->associate_id) && $user->associate->id == \request()->associate_id);
        //o que estava
        //return $user->can('manageApp') || (!empty($user->associate) && empty($user->associate->declarations));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Declaration  $declaration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Declaration $declaration)
    {
        return $user->can('manageApp') || $declaration->associate->id == $user->associate->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Declaration  $declaration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Declaration $declaration)
    {
        return $user->can('manageApp');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Declaration  $declaration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Declaration $declaration)
    {
        return $user->can('manageApp');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Declaration  $declaration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Declaration $declaration)
    {
        return $user->can('manageApp');
    }
}
