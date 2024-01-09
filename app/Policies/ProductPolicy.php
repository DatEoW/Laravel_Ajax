<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->group_role, [User::ADMIN,User::EDITOR,User::REVIEWER]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return in_array($user->group_role, [User::ADMIN,User::EDITOR,User::REVIEWER]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return in_array($user->group_role, [User::ADMIN,User::EDITOR])
        ? Response::allow()
        : Response::deny('Bạn không đủ quyền');


    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return in_array($user->group_role,[User::ADMIN,User::EDITOR])

        ? Response::allow()
        : Response::deny('Bạn không đủ quyền');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return in_array($user->group_role, [User::ADMIN,User::EDITOR])
        ? Response::allow()
        : Response::deny('Bạn không đủ quyền');
    }

}
