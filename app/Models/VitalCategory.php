<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class VitalCategory extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'vital_categories';

    /** Mass assignable attributes */
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'status',
        'created_by',
    ];

    /** Scope: active categories only */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /** Scope: inactive categories only */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
