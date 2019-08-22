<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 4/23/19
 * Time: 11:49 AM
 */

namespace Edumedics\DataModels\Listeners\Patient;

use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Events\Patient\PatientCreate;
use Edumedics\DataModels\Events\Patient\PatientUpdate;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Log;

class FlagPossiblePatientDuplicates extends ListenerAppResolver
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->resolveService('FlagDuplicatePatientsService');
    }

    /**
     * @param Event $event
     */
    public function handle(Event $event)
    {
        if (isset($this->resolvedService)) {
            try
            {
                $eventType = get_class($event);
                if ($eventType == PatientUpdate::class || $eventType == PatientCreate::class)
                {
                    $this->resolvedService->evaluatePatient($event->patient, 2, true);
                }
            }
            catch (\Exception $e)
            {
                Log::info("Error on Flagging Duplicate Patients: " . $e->getMessage());
            }
        }


    }

}