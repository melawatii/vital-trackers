<?php

namespace App\Models;

use Illuminate\Support\Str;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

/**
 * User model.
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * Collection name.
     *
     * @var string
     */
    protected $collection = 'users';

    /**
     * Fillable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
        'created_by',
        'created_time',
    ];

    /**
     * Hidden attributes.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attributes.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Boot model events.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {

            // Generate ULID
            $user->uuid = (string) Str::ulid();

            // Default role
            if (! $user->role) {
                $user->role = 'user';
            }

            // Set created timestamp
            $user->created_time = now();
        });
    }

    /**
     * Get authentication identifier name.
     */
    public function getAuthIdentifierName()
    {
        return '_id';
    }

    /**
     * Get route key value.
     */
    public function getRouteKey()
    {
        return (string) $this->_id;
    }

    /**
     * Get email for verification.
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }

    /**
     * Get user vital records.
     */
    public function vitalRecords()
    {
        return $this->hasMany(
            VitalRecord::class,
            'user_id'
        );
    }

    /**
     * Check admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check normal user role.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}