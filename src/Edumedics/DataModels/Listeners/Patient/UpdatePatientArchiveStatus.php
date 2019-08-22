<?php


namespace Edumedics\DataModels\Listeners\Patient;


use Edumedics\DataModels\Events\Patient\PatientUpdate;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Log;

class UpdatePatientArchiveStatus extends ListenerAppResolver
{
    /**
     * UpdatePatientSnapshot constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->resolveService('PatientService');
    }

    /**
     * Handle the event.
     *
     * @param  PatientUpdate $event
     * @return void
     */
    public function handle(PatientUpdate $event)
    {
        if (isset($this->resolvedService))
        {
            $changedAttributes = $event->patient->getDirty();
            if (isset($changedAttributes['client_id']))
            {
                try
                {
                    $this->resolvedService->updatePatientArchiveStatus($event->patient->_id);
                }
                catch (\Exception $e)
                {
                    Log::info("Update Patient Archive Status failed: " . $e->getMessage());
                }
            }
        }
    }
}