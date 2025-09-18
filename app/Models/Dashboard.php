<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'platform',
        'url',
        'visibility',
        'scope',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    // Relacionamentos
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'dashboard_organization')
                    ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'dashboard_user')
                    ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'dashboard_role')
                    ->withTimestamps();
    }

    // Métodos auxiliares para verificar o escopo
    public function isOrganizationScope()
    {
        return $this->scope === 'organization';
    }

    public function isProfileScope()
    {
        return $this->scope === 'profile';
    }

    public function isUserScope()
    {
        return $this->scope === 'user';
    }
}