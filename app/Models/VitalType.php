<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class VitalType extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'vital_types';

    /** Mass assignable attributes */
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'input_type',
        'unit',
        'min_value',
        'max_value',
        'normal_range_min',
        'normal_range_max',
        'sort_order',
        'note',
        'status',
        'created_by',
    ];

    /** Scope: active vital types only */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /** Scope: inactive vital types only */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /** Scope: numeric input types only */
    public function scopeNumeric($query)
    {
        return $query->where('input_type', 'number');
    }

    /** Relationship: belongs to a VitalCategory */
    public function category()
    {
        return $this->belongsTo(VitalCategory::class, 'category_id');
    }

    /** Get formatted normal range string e.g. "40 - 120" */
    public function getNormalRangeAttribute(): string
    {
        if ($this->normal_range_min !== null && $this->normal_range_max !== null) {
            return $this->normal_range_min . ' - ' . $this->normal_range_max;
        }
        return '-';
    }
}
