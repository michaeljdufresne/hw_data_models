<?php


namespace Edumedics\DataModels\Listeners\Patient;

use Edumedics\DataModels\Events\Patient\PatientPostArchiveAction;
use Edumedics\DataModels\Events\Patient\PatientUnarchive;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Log;

class PatientCascadeUnarchive extends ListenerAppResolver
{
    /**
     * UpdateRiskProfile constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->resolveService('PatientArchivingService');
    }

    /**
     * Handle the event.
     *
     * @param  PatientUnarchive $event
     * @return void
     */
    public function handle(PatientUnarchive $event)
    {
        if (isset($this->resolvedService)) {
            try {
                $this->resolvedService->cascadePatientUnarchive($event->patient);
                event(new PatientPostArchiveAction($event->patient));
            } catch (\Exception $e) {
                Log::info("Cascade Patient Unarchive Failed: " . $e->getMessage());
            }
        }
    }
}
