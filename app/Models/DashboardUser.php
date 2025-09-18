<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DashboardUser extends Pivot
{
    use HasFactory;

    protected $table = 'dashboard_user';

    protected $fillable = [
        'dashboard_id',
        'user_id',
    ];
}