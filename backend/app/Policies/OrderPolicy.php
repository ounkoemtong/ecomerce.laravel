<?php

namespace App\Policies;

use App\Models\OrderModel;
use App\Models\User;
use App\Policies\Concerns\HandlesAdminAccess;

class OrderPolicy
{
    use HandlesAdminAccess;

    public function viewAny(User $user): bool
    {
        return $user->status === 'active';
    }

    public function view(User $user, OrderModel $order): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $order);
    }

    public function create(User $user): bool
    {
        return $user->status === 'active';
    }

    public function update(User $user, OrderModel $order): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $order);
    }

    public function delete(User $user, OrderModel $order): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $order);
    }
}
