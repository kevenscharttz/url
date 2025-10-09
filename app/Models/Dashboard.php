<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'organization_id',
        'type',
        'platform',
        'url',
        'visibility',
        'scope_user_id',
        'scope_profile_id',
        'scope_organization_id',
        'tags',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'tags' => 'array',
    ];

    // 🔗 Relacionamentos
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Scope dashboards visible to a given user.
     * Usage: Dashboard::visibleTo($user)->get();
     */
    public function scopeVisibleTo($query, $user)
    {
        if (! $user) {
            // only public dashboards for guests
            return $query->where('visibility', 'public');
        }

        // Super-admins or users with global view permission should see everything
        $isSuper = false;
        if (method_exists($user, 'getRoleNames')) {
            $roles = $user->getRoleNames()->toArray();
            foreach ($roles as $r) {
                $normalized = strtolower(preg_replace('/[^a-z0-9]/', '', $r));
                if (in_array($normalized, ['superadmin', 'super'], true)) {
                    $isSuper = true;
                    break;
                }
            }
        }

        if ($isSuper || (method_exists($user, 'can') && ($user->can('View:Dashboard') || $user->can('ViewAny:Dashboard')))) {
            return $query; // no filters
        }

        $organizationIds = $user->organizations()->pluck('organizations.id')->toArray();
        $roleIds = [];
        if (method_exists($user, 'roles')) {
            $roleIds = $user->roles()->pluck('roles.id')->toArray();
        }

                return $query->where(function ($q) use ($user, $organizationIds, $roleIds) {
                        // public dashboards
                        $q->where('visibility', 'public')
                            // explicitly assigned to user
                            ->orWhere('scope_user_id', $user->id)
                            // dashboard belongs to one of user's organizations (organization owner)
                            ->orWhereIn('organization_id', $organizationIds)
                            // assigned to one of user's roles/profiles
                            ->orWhereIn('scope_profile_id', $roleIds);
                });
    }
}
