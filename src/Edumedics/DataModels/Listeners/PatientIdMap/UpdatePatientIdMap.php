<?php


namespace Edumedics\DataModels\Listeners\PatientIdMap;

use Edumedics\DataModels\Events\Patient\PatientUpdate;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Log;

class UpdatePatientIdMap extends ListenerAppResolver
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->resolveService('PatientService');
    }

    /**
     * Handle the event.
     *
     * @param  PatientUpdate  $event
     * @return void
     */
    public function handle(PatientUpdate $event)
    {
        if (isset($this->resolvedService))
        {
            try
            {
                $this->resolvedService->updatePatientIdMap($event->patient);
            }
            catch (\Exception $e) {
                Log::info("Update Patient Id Map Failed: " . $e->getMessage());
            }
        }
    }
}