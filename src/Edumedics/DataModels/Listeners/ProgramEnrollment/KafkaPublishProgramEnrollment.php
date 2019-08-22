<?php

namespace Edumedics\DataModels\Listeners\ProgramEnrollment;

use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Events\ProgramEnrollment\ProgramEnrollmentDelete;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishProgramEnrollment extends ListenerAppResolver
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
                if ($eventType == ProgramEnrollmentDelete::class)
                {
                    $eventCopy->participantProgramEnrollment = $eventCopy->participantProgramEnrollment->toArray();
                }

                $this->resolvedService->kafkaProducerQueue->push($this->getTopic($eventType),
                    new EventTransferModel(Event::getEnvConfig(),get_class($eventCopy), $eventCopy)
                );
            }
            catch (\Exception $e)
            {
                Log::info("Produce ProgramEnrollment to Kafka failed: " . $e->getMessage());
            }
        }
        else
        {
            Log::info("Unable to resolve KafkaProxyService or find Kafka Producer Queue - KafkaPublishProgramEnrollment");
        }

    }
}