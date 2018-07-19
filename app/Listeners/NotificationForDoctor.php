<?php

namespace App\Listeners;

use App\Events\ReceiveAppointment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationForDoctor
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
     * @param  ReceiveAppointment  $event
     * @return void
     */
    public function handle(ReceiveAppointment $event)
    {
        //
        \Log::info('Appointment', ['appointment' => $event->appointment]);
    }
}
