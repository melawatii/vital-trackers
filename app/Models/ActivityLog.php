<?php

namespace App\Models;

use Illuminate\Support\Str;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Model representing an activity log entry in the system.
 */
class ActivityLog extends Model
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
    protected $collection = 'activity_logs';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
        'created_time',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Boot the model and attach model event listeners.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Automatically generate a ULID for the uuid field upon creation
            $model->uuid = (string) Str::ulid();

            // Set the custom created_time timestamp since default Eloquent timestamps are disabled
            $model->created_time = now();
        });
    }

    /**
     * Get the user that owns the activity log.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
