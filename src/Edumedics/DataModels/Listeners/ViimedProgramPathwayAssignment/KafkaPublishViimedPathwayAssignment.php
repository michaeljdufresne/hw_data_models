<?php


namespace Edumedics\DataModels\Listeners\ViimedProgramPathwayAssignment;


use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Events\ViimedProgramPathwayAssignment\ViimedPathwayAssignmentDelete;
use Edumedics\DataModels\Events\ViimedProgramPathwayAssignment\ViimedPathwayAssignmentUpdate;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishViimedPathwayAssignment extends ListenerAppResolver
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
                $customAttributes = [];

                $eventType = get_class($eventCopy);
                if ($eventType == ViimedPathwayAssignmentDelete::class)
                {
                    $eventCopy->viimedProgramPathwayAssignment = $eventCopy->viimedProgramPathwayAssignment->toArray();
                }
                elseif ($eventType == ViimedPathwayAssignmentUpdate::class)
                {
                    $customAttributes['previousObject'] = $event->viimedProgramPathwayAssignment->getOriginal();
                }

                $this->resolvedService->kafkaProducerQueue->push($this->getTopic($eventType),
                    new EventTransferModel(Event::getEnvConfig(), get_class($eventCopy), $eventCopy, $customAttributes)
                );

            }
            catch (\Exception $e)
            {
                Log::info("Produce ViimedProgramPathwayAssignment to Kafka failed: " . $e->getMessage());
            }
        }
        else
        {
            Log::info("Unable to resolve KafkaProxyService or find Kafka Producer Queue - ViimedProgramPathwayAssignment");
        }

    }
}