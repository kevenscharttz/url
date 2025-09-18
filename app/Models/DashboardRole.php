<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DashboardRole extends Pivot
{
    use HasFactory;

    protected $table = 'dashboard_role';

    protected $fillable = [
        'dashboard_id',
        'role_id',
    ];
}