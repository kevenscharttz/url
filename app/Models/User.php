<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relacionamentos
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_user')
                    ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')
                    ->withPivot('organization_id')
                    ->withTimestamps();
    }

    public function dashboards()
    {
        return $this->belongsToMany(Dashboard::class, 'dashboard_user')
                    ->withTimestamps();
    }
}