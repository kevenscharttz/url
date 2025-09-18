<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'scope', // Já existe na tabela roles (enum: global, organization)
    ];

    // Métodos auxiliares para verificar o escopo
    public function isGlobalScope()
    {
        return $this->scope === 'global';
    }

    public function isOrganizationScope()
    {
        return $this->scope === 'organization';
    }

    // Relacionamentos
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user')
                    ->withPivot('organization_id')
                    ->withTimestamps();
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_role')
                    ->withTimestamps();
    }

    public function dashboards()
    {
        return $this->belongsToMany(Dashboard::class, 'dashboard_role')
                    ->withTimestamps();
    }
}