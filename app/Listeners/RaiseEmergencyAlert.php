<?php

namespace App\Listeners;

use App\Events\HasEmergencySituation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\Emergency\DistributeUrgentContact;
use Artisan;

class RaiseEmergencyAlert
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
     * @param  HasEmergencySituation  $event
     * @return void
     */
    public function handle(HasEmergencySituation $event)
    {
        DistributeUrgentContact::dispatch($event->urgentContact);

       // Artisan::call('queue:work --queue=high,default --stop-when-empty');
    }
}
