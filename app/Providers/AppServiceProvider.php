<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use App\Policies\AppointmentPolicy;
use App\Policies\ClientPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected array $policies = [
        User::class => UserPolicy::class,
        Client::class => ClientPolicy::class,
        Appointment::class => AppointmentPolicy::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
