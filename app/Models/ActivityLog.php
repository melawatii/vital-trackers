<?php

namespace App\Models;

use Illuminate\Support\Str;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Activity log model.
 */
class ActivityLog extends Model
{
    /**
     * Collection name.
     *
     * @var string
     */
    protected $collection = 'activity_logs';

    /**
     * Primary key.
     *
     * @var string
     */
    protected $primaryKey = '_id';

    /**
     * Fillable attributes.
     *
     * @var array
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
     * Disable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Boot model event.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            /**
             * Generate UUID.
             */
            $model->uuid = (string) Str::ulid();

            /**
             * Generate created time.
             */
            $model->created_time = now();
        });
    }

    /**
     * User relation.
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
