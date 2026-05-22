<?php

namespace App\Providers;

use App\Models\VitalRecord;

use App\Policies\VitalRecordPolicy;

use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Authentication service provider.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Application policies.
     *
     * @var array
     */
    protected $policies = [

        VitalRecord::class => VitalRecordPolicy::class,
    ];

    /**
     * Bootstrap authorization services.
     */
    public function boot(): void
    {
        /**
         * Register policies.
         */
        $this->registerPolicies();

        /**
         * Define admin gate.
         */
        Gate::define(

            'admin-access',

            function ($user) {

                return $user->role === 'admin';
            }
        );
    }
}