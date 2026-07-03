<?php

namespace App\Policies;

use App\Models\ReviewModel;
use App\Models\User;
use App\Policies\Concerns\HandlesAdminAccess;

class ReviewPolicy
{
    use HandlesAdminAccess;

    public function viewAny(User $user): bool
    {
        return $user->status === 'active';
    }

    public function view(User $user, ReviewModel $review): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $review);
    }

    public function create(User $user): bool
    {
        return $user->status === 'active';
    }

    public function update(User $user, ReviewModel $review): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $review);
    }

    public function delete(User $user, ReviewModel $review): bool
    {
        return $this->isAdmin($user) || $this->ownsModel($user, $review);
    }
}
