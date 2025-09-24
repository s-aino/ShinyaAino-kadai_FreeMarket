<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /** @var array<class-string, array<int, class-string>> */
    protected $listen = [
        // \App\Events\SomeEvent::class => [\App\Listeners\SomeListener::class],
    ];

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
