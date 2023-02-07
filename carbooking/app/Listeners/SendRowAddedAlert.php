<?php

namespace App\Listeners;

use App\Events\NewRowAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRowAddedAlert
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
     * @param  \App\Events\NewRowAdded  $event
     * @return void
     */
    public function handle(NewRowAdded $event)
    {
        // Code to send an alert with $event->data
        return redirect()->back()->with('alert', 'A new row has been added to the database!');
    }
}
