<?php

namespace App\Models;

use App\Models\User;
use App\Models\VitalCategory;
use App\Models\VitalType;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Model representing a recorded vital sign measurement for a user.
 */
class VitalRecord extends Model
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
    protected $collection = 'vital_records';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Ensure recorded_at is cast to a Carbon instance for easy date manipulation
        'recorded_at' => 'datetime',
    ];

    /**
     * Scope a query to only include records with a normal status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNormal($query)
    {
        return $query->where('status', 'normal');
    }

    /**
     * Scope a query to only include records with a high/low (danger) status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDanger($query)
    {
        return $query->where('status', 'high_low');
    }

    /**
     * Scope a query to only include records logged within the current month.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeThisMonth($query)
    {
        return $query->where('recorded_at', '>=', now()->startOfMonth());
    }

    /**
     * Get the user that owns the vital record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the vital category that the record belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(VitalCategory::class, 'category_id');
    }

    /**
     * Get the vital type that the record belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vitalType()
    {
        return $this->belongsTo(VitalType::class, 'type_id');
    }
}
