<?php

namespace App\Policies;

use App\Enums\Role;
use App\Enums\Status;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CampaignPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user && in_array($user->role, [Role::ADMIN, Role::VIWER])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Campaign $campaign): bool
    {
        if ($user && in_array($user->role, [Role::ADMIN, Role::VIWER])) {
            return true;
        }

        if ($campaign->status !== Status::PUBLISHED) {
            return false;
        }

        if ($campaign->publish_date?->isFuture()) {
            return false;
        }

        if ($campaign->end_date->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->role === Role::ADMIN) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campaign $campaign): bool
    {
        if ($user->role === Role::ADMIN) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        if ($user->role === Role::ADMIN) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Campaign $campaign): bool
    {
        if ($user->role === Role::ADMIN) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Campaign $campaign): bool
    {
        if ($user->role === Role::ADMIN) {
            return true;
        }

        return false;
    }
}
