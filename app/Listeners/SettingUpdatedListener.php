<?php

namespace App\Listeners;

use App\Events\SettingUpdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SettingUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SettingUpdatedEvent  $event
     * @return void
     */
    public function handle( SettingUpdatedEvent $event )
    {
        
    }
}
