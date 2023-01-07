<?php

namespace App\Providers;

use App\Models\Associate;
use App\Models\Declaration;
use App\Models\DeclarationTemplate;
use App\Models\FindAp;
use App\Models\Order;
use App\Models\User;
use App\Observers\AssociateObserver;
use App\Observers\DeclarationObserver;
use App\Observers\DeclarationTemplateObserver;
use App\Observers\FindApObserver;
use App\Observers\OrderObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        Associate::observe(AssociateObserver::class);
        Declaration::observe(DeclarationObserver::class);
        DeclarationTemplate::observe(DeclarationTemplateObserver::class);
        FindAp::observe(FindApObserver::class);
        User::observe(UserObserver::class);
    }
}
