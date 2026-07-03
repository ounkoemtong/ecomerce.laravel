<?php

namespace App\Policies\Concerns;

use App\Models\User;

trait HandlesAdminAccess
{
    protected function isAdmin(User $user): bool
    {
        return $user->role?->name === 'admin';
    }

    protected function ownsModel(User $user, object $model): bool
    {
        return isset($model->user_id) && (int) $model->user_id === (int) $user->id;
    }
}
