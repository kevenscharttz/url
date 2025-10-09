<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Dashboard;
use Illuminate\Auth\Access\HandlesAuthorization;

class DashboardPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Dashboard');
    }

    public function view(AuthUser $authUser, Dashboard $dashboard): bool
    {
        // Super-admins / users with global permission can bypass
        if ($authUser->can('View:Dashboard')) {
            return true;
        }

        // Public dashboards are visible
        if ($dashboard->visibility === 'public') {
            return true;
        }

        // If dashboard is scoped to a specific user
        if ($dashboard->scope_user_id && $dashboard->scope_user_id === $authUser->id) {
            return true;
        }

        // If the dashboard belongs to an organization, check membership
        if ($dashboard->organization_id) {
            $orgIds = $authUser->organizations()->pluck('organizations.id')->toArray();
            if (in_array($dashboard->organization_id, $orgIds, true)) {
                return true;
            }
        }

        // Profile/role scope (stored as scope_profile_id)
        if ($dashboard->scope_profile_id) {
            if (method_exists($authUser, 'roles')) {
                $roleIds = $authUser->roles()->pluck('roles.id')->toArray();
                if (in_array($dashboard->scope_profile_id, $roleIds, true)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Dashboard');
    }

    public function update(AuthUser $authUser, Dashboard $dashboard): bool
    {
        return $authUser->can('Update:Dashboard');
    }

    public function delete(AuthUser $authUser, Dashboard $dashboard): bool
    {
        return $authUser->can('Delete:Dashboard');
    }

    public function restore(AuthUser $authUser, Dashboard $dashboard): bool
    {
        return $authUser->can('Restore:Dashboard');
    }

    public function forceDelete(AuthUser $authUser, Dashboard $dashboard): bool
    {
        return $authUser->can('ForceDelete:Dashboard');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Dashboard');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Dashboard');
    }

    public function replicate(AuthUser $authUser, Dashboard $dashboard): bool
    {
        return $authUser->can('Replicate:Dashboard');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Dashboard');
    }

}