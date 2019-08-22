<?php

namespace Edumedics\DataModels\Listeners\Patient;

use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Events\Patient\PatientDelete;
use Edumedics\DataModels\Events\Patient\PatientUpdate;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishPatient extends ListenerAppResolver
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
     * @param Event $event
     */
    public function handle(Event $event)
    {
        if (isset($this->resolvedService) && isset($this->resolvedService->kafkaProducerQueue))
        {
            try
            {
                //get a copy of the event so that it remains unchanged
                $eventCopy = Event::deepCopy($event);
                $customAttributes = [];

                $eventType = get_class($eventCopy);
                if ($eventType == PatientDelete::class)
                {
                    $eventCopy->patient = $event->patient->toArray();
                }
                elseif ($eventType == PatientUpdate::class)
                {
                    $customAttributes['changedAttributes'] = $event->patient->getDirty();
                }

                $this->resolvedService->kafkaProducerQueue->push($this->getTopic($eventType),
                    new EventTransferModel(Event::getEnvConfig(),get_class($eventCopy), $eventCopy, $customAttributes), 5
                );
            }
            catch (\Exception $e)
            {
                Log::info("Produce Patient to Kafka failed: " . $e->getMessage());
            }
        }
        else
        {
            Log::info("Unable to resolve KafkaProxyService or find Kafka Producer Queue - KafkaPublishPatient");
        }
    }

}