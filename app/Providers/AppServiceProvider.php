<?php

namespace App\Providers;

use App\Models\User;
use App\Models\VitalRecord;
use App\Observers\UserObserver;
use App\Policies\VitalRecordPolicy;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

/**
 * Application service provider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /**
         * Register user observer.
         */
        User::observe(UserObserver::class);

        /**
         * Register policies.
         */
        Gate::policy(VitalRecord::class, VitalRecordPolicy::class);

        /**
         * Use custom branded view for the email verification notification,
         * instead of Laravel's default plain template.
         */
        VerifyEmail::toMailUsing(function ($notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Your Email Address')
                ->view('emails.verify-email', ['url' => $url]);
        });
    }
}
