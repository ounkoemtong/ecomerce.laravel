<?php

namespace App\Policies;

use App\Models\AddressesModel;
use App\Models\User;
use App\Policies\Concerns\HandlesAdminAccess;

class AddressPolicy
{
    use HandlesAdminAccess;

    public function viewAny(User $user): bool
    {
        return $user->status === 'active';
    }

    public function view(User $user, AddressesModel $address): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $address);
    }

    public function create(User $user): bool
    {
        return $user->status === 'active';
    }

    public function update(User $user, AddressesModel $address): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $address);
    }

    public function delete(User $user, AddressesModel $address): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $address);
    }
}
