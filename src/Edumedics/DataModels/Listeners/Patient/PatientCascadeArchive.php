<?php


namespace Edumedics\DataModels\Listeners\Patient;

use Edumedics\DataModels\Events\Patient\PatientArchive;
use Edumedics\DataModels\Events\Patient\PatientPostArchiveAction;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Log;

class PatientCascadeArchive extends ListenerAppResolver
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
     * @param  PatientArchive $event
     * @return void
     */
    public function handle(PatientArchive $event)
    {
        if (isset($this->resolvedService)) {
            try {
                $this->resolvedService->cascadePatientArchive($event->patient);
                event(new PatientPostArchiveAction($event->patient));
            } catch (\Exception $e) {
                Log::info("Cascade Patient Archive Failed: " . $e->getMessage());
            }
        }
    }
}
