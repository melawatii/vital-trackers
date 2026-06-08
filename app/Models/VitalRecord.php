<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class VitalRecord extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'vital_records';

    /** Mass assignable attributes */
    protected $fillable = [
        'user_id',
        'category_id',
        'type_id',
        'value',
        'unit',
        'status',
        'note',
        'recorded_at',
    ];

    /** Cast recorded_at as datetime */
    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    /** Scope: normal status records */
    public function scopeNormal($query)
    {
        return $query->where('status', 'normal');
    }

    /** Scope: high/low (danger) status records */
    public function scopeDanger($query)
    {
        return $query->where('status', 'high_low');
    }

    /** Scope: records created this month */
    public function scopeThisMonth($query)
    {
        return $query->where('recorded_at', '>=', now()->startOfMonth());
    }

    /** Relationship: belongs to a User */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /** Relationship: belongs to a VitalCategory */
    public function category()
    {
        return $this->belongsTo(VitalCategory::class, 'category_id');
    }

    /** Relationship: belongs to a VitalType */
    public function vitalType()
    {
        return $this->belongsTo(VitalType::class, 'type_id');
    }
}
