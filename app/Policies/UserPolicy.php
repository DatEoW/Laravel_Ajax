<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->group_role, [User::ADMIN, User::EDITOR]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return in_array($user->group_role, [User::ADMIN, User::EDITOR]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->group_role === User::ADMIN ? Response::allow()
            : Response::deny('Bạn không đủ quyền');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user): Response
    {
        return $user->group_role === User::ADMIN ? Response::allow()
            : Response::deny('Bạn không đủ quyền');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function changeUser(User $user): Response
    {

        return $user->group_role === User::ADMIN ? Response::allow()
            : Response::deny('Bạn không đủ quyền');
    }

    /**
     * Determine whether the user can restore the model.
     */


    /**
     * Determine whether the user can permanently delete the model.
     */
}
