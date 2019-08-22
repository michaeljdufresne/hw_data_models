<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-06-25
 * Time: 15:43
 */

namespace Edumedics\DataModels\Listeners\PatientSubscription;


use Edumedics\DataModels\Events\Patient\PatientCreate;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Log;

class CreatePatientSubscription extends ListenerAppResolver
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
                $this->resolvedService->createPatientSubscription($event->patient);
            } catch (\Exception $e) {
                Log::info("Create Patient Subscription Failed: " . $e->getMessage());
            }
        }
    }
}