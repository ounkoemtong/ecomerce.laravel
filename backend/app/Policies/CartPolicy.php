<?php

namespace App\Policies;

use App\Models\CartModel;
use App\Models\User;
use App\Policies\Concerns\HandlesAdminAccess;

class CartPolicy
{
    use HandlesAdminAccess;

    public function viewAny(User $user): bool
    {
        return $user->status === 'active';
    }

    public function view(User $user, CartModel $cart): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $cart);
    }

    public function create(User $user): bool
    {
        return $user->status === 'active';
    }

    public function update(User $user, CartModel $cart): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $cart);
    }

    public function delete(User $user, CartModel $cart): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $cart);
    }
}
