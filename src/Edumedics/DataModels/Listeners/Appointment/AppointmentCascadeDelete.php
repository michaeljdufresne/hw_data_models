<?php


namespace Edumedics\DataModels\Listeners\Appointment;


use Edumedics\DataModels\Events\Appointment\AppointmentDelete;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Log;

class AppointmentCascadeDelete extends ListenerAppResolver
{
    /**
     * AppointmentCascadeDelete constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->resolveService('AppointmentService');
    }

    /**
     * Handle the event.
     *
     * @param  AppointmentDelete $event
     * @return void
     */
    public function handle(AppointmentDelete $event)
    {
        if (isset($this->resolvedService)) {
            try {
                $this->resolvedService->cascadeAppointmentDelete($event->appointment);
            } catch (\Exception $e) {
                Log::info("Cascade Delete Appointment Failed: " . $e->getMessage());
            }
        }
    }
}