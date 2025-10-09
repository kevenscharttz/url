<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'created_by',
    ];

    // 🔗 Relacionamentos
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function dashboards()
    {
        return $this->hasMany(Dashboard::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
