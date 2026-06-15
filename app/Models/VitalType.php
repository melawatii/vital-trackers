<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

/**
 * Model representing a specific type of vital sign measurement.
 */
class VitalType extends Model
{
    /**
     * The database connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * The MongoDB collection associated with the model.
     *
     * @var string
     */
    protected $collection = 'vital_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * Scope a query to only include active vital types.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive vital types.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to only include numeric input vital types.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNumeric($query)
    {
        return $query->where('input_type', 'number');
    }

    /**
     * Get the vital category that this type belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(VitalCategory::class, 'category_id');
    }

    /**
     * Get the formatted normal range string (e.g., "40 - 120").
     *
     * @return string
     */
    public function getNormalRangeAttribute(): string
    {
        // Combine min and max values into a readable range if both are present
        if ($this->normal_range_min !== null && $this->normal_range_max !== null) {
            return $this->normal_range_min . ' - ' . $this->normal_range_max;
        }

        // Return a dash if the range is not fully defined
        return '-';
    }
}
