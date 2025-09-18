<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Relacionamentos
    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_user')
                    ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'organization_role')
                    ->withTimestamps();
    }

    public function dashboards()
    {
        return $this->belongsToMany(Dashboard::class, 'dashboard_organization')
                    ->withTimestamps();
    }
}