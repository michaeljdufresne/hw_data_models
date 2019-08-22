<?php


namespace Edumedics\DataModels\Listeners\PatientClient;


use Edumedics\DataModels\Events\Patient\PatientUpdate;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Log;

class UpdatePatientClient extends ListenerAppResolver
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
        if (isset($this->resolvedService)) {
            try {
                $this->resolvedService->updatePatientClientRelationship($event->patient);
            } catch (\Exception $e) {
                Log::info("Update Patient Client Relationship Failed: " . $e->getMessage());
            }
        }
    }
}