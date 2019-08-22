<?php

namespace Edumedics\DataModels\Listeners\PatientCarePlan;

use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Events\PatientCarePlans\PatientCarePlanDelete;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishPatientCarePlan extends ListenerAppResolver
{

    use KafkaTopicMapTrait;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->resolveService('KafkaProxyService');
    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (isset($this->resolvedService) && isset($this->resolvedService->kafkaProducerQueue))
        {
            try
            {
                //get a copy of the event so that it remains unchanged
                $eventCopy = Event::deepCopy($event);

                $eventType = get_class($eventCopy);
                if ($eventType == PatientCarePlanDelete::class)
                {
                    $eventCopy->patientCarePlan = $eventCopy->patientCarePlan->toArray();
                }

                $this->resolvedService->kafkaProducerQueue->push($this->getTopic($eventType),
                    new EventTransferModel(Event::getEnvConfig(),get_class($eventCopy), $eventCopy)
                );
            }
            catch (\Exception $e)
            {
                Log::info("Produce PatientCarePlan to Kafka failed: " . $e->getMessage());
            }
        }
        else
        {
            Log::info("Unable to resolve KafkaProxyService or find Kafka Producer Queue - KafkaPublishPatientCarePlan");
        }

    }
}