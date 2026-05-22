<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VitalCategory extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'vital_categories';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'icon',
        'description',
        'status',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'status' => 'string',
    ];

    // ─────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────

    /** User who created this category */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ─────────────────────────────────────────────
    // Scopes
    // ─────────────────────────────────────────────

    /** Filter only active categories */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /** Filter only inactive categories */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    // ─────────────────────────────────────────────
    // Accessors
    // ─────────────────────────────────────────────

    /** Check if category is active */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }
}
