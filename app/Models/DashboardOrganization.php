<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DashboardOrganization extends Pivot
{
    use HasFactory;

    protected $table = 'dashboard_organization';

    protected $fillable = [
        'dashboard_id',
        'organization_id',
    ];
}