<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Santri;

class SantriPolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['super_admin', 'admin', 'viewer']);
    }

    public function view(User $user, Santri $santri)
    {
        return in_array($user->role, ['super_admin', 'admin', 'viewer']);
    }

    public function create(User $user)
    {
        return in_array($user->role, ['super_admin', 'admin']);
    }

    public function update(User $user, Santri $santri)
    {
        return in_array($user->role, ['super_admin', 'admin']);
    }

    public function delete(User $user, Santri $santri)
    {
        return in_array($user->role, ['super_admin', 'admin']);
    }
}
