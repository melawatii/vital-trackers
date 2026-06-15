<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

/**
 * Model representing a category for vital signs.
 */
class VitalCategory extends Model
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
    protected $collection = 'vital_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'status',
        'created_by',
    ];

    /**
     * Scope a query to only include active categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
