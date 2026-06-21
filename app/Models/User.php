<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use MongoDB\Laravel\Auth\User as Authenticatable;

/**
 * Model representing a system user.
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

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
    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'username',
        'email',
        'password',
        'role',
        'phone',
        'status',
        'email_verified_at',
        'last_login_at',
        'created_by',
        'created_time',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Boot the model and attach model event listeners.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Automatically generate a ULID for the uuid field upon creation
            $user->uuid = (string) Str::ulid();

            // Assign default 'user' role if not explicitly provided
            if (! $user->role) {
                $user->role = 'user';
            }

            // Assign default 'active' status if not explicitly provided
            if (! $user->status) {
                $user->status = 'active';
            }

            // Set the custom created_time timestamp since default Eloquent timestamps are disabled
            $user->created_time = now();
        });
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return '_id';
    }

    /**
     * Get the value of the model's route key.
     *
     * @return string
     */
    public function getRouteKey()
    {
        return (string) $this->_id;
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }

    /**
     * Get the vital records associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vitalRecords()
    {
        return $this->hasMany(VitalRecord::class, 'user_id');
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include users of a specific role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $role
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    /**
     * Determine if the user has the administrator role.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Determine if the user has the standard user role.
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Get the human-readable label for the user's role.
     *
     * @return string
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'user'  => 'User',
            default => ucfirst($this->role ?? 'User'),
        };
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmail());
    }
}
