<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VitalRecord extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'vital_records';

    protected $fillable = [
        'user_id',
        'category_id',
        'vital_type_id',
        'vital_name',
        'unit',
        'value',
        'status',
        'note',
        'measured_at',
        'created_by',
    ];

    protected $casts = [
        'measured_at' => 'datetime',
    ];

    // ──────────────────────────────
    // Relationships
    // ──────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(VitalCategory::class, 'category_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(VitalType::class, 'vital_type_id');
    }

    // ──────────────────────────────
    // Accessors
    // ──────────────────────────────
    public function getIsNormalAttribute(): bool
    {
        return $this->status === 'normal';
    }
}
