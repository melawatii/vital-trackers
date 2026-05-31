<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class VitalType extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'vital_types';

    protected $fillable = [
        'name',
        'category_id',
        'unit',
        'input_type',
        'min_value',
        'max_value',
        'normal_range_min',
        'normal_range_max',
        'status', // should hold 'active' or 'inactive'
        'sort_order',
        'note',
        'created_by',
    ];

    /**
     * Cast status to string
     */
    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Scope to filter only active types
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if type is active
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Relationships
     */
    public function category()
    {
        return $this->belongsTo(VitalCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
