<?php


namespace Edumedics\DataModels\Listeners\Patient;

use Edumedics\DataModels\Events\Patient\PatientDelete;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Log;

class PatientCascadeDelete extends ListenerAppResolver
{
    /**
     * UpdateRiskProfile constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->resolveService('PatientService');
    }

    /**
     * Handle the event.
     *
     * @param  PatientDelete $event
     * @return void
     */
    public function handle(PatientDelete $event)
    {
        if (isset($this->resolvedService)) {
            try {
                $this->resolvedService->cascadePatientDelete($event->patient);
            } catch (\Exception $e) {
                Log::info("Cascade Delete Patient Failed: " . $e->getMessage());
            }
        }
    }
}
