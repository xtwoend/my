<?php

namespace App\Providers;

use App\Models\Pallet;
use App\Models\Inventory;
use App\Events\MQTTReceived;
use App\Models\ProductReturn;
use App\Observers\PalletObserver;
use App\Observers\InventoryObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Observers\ProductReturnObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MQTTReceived::class => [
            \App\Listeners\InventoryInListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Inventory::observe(InventoryObserver::class);
        Pallet::observe(PalletObserver::class);
        ProductReturn::observe(ProductReturnObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
