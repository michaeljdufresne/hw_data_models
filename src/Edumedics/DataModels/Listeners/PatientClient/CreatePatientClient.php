<?php


namespace Edumedics\DataModels\Listeners\PatientClient;


use Edumedics\DataModels\Events\Patient\PatientCreate;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Log;

class CreatePatientClient extends ListenerAppResolver
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
     * @param  PatientCreate  $event
     * @return void
     */
    public function handle(PatientCreate $event)
    {
        if (isset($this->resolvedService)) {
            try {
                $this->resolvedService->createPatientClientRelationship($event->patient);
            } catch (\Exception $e) {
                Log::info("Create Patient Client Relationship Failed: " . $e->getMessage());
            }
        }
    }
}