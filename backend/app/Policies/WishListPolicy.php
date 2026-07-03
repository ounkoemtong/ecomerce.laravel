<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WishListModel;
use App\Policies\Concerns\HandlesAdminAccess;

class WishListPolicy
{
    use HandlesAdminAccess;

    public function viewAny(User $user): bool
    {
        return $user->status === 'active';
    }

    public function view(User $user, WishListModel $wishList): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $wishList);
    }

    public function create(User $user): bool
    {
        return $user->status === 'active';
    }

    public function update(User $user, WishListModel $wishList): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $wishList);
    }

    public function delete(User $user, WishListModel $wishList): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $wishList);
    }
}
