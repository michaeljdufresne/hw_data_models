<?php

namespace Edumedics\DataModels\Listeners\PatientSnapshot;

use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Events\PatientSnapshot\PatientSnapshotUpdate;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishPatientSnapshot extends ListenerAppResolver
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
                $eventType = get_class($event);
                $reassessCarePlans = null;

                if ($eventType == PatientSnapshotUpdate::class)
                {
                    $reassessCarePlans= true;
                    $changedAttributes = $event->patientSnapshot->getDirty();

                    unset($changedAttributes['updated_at']);
                    if (count($changedAttributes) == 1 && isset($changedAttributes['careplan_ids']))
                    {
                        $reassessCarePlans = false;
                    }
                }

                $this->resolvedService->kafkaProducerQueue->push($this->getTopic($eventType),
                    new EventTransferModel(Event::getEnvConfig(), get_class($event),
                        $event, ['reassessCarePlans' => $reassessCarePlans])
                );
            }
            catch (\Exception $e)
            {
                Log::info("Produce PatientSnapshot to Kafka failed: " . $e->getMessage());
            }
        }
        else
        {
            Log::info("Unable to resolve KafkaProxyService or find Kafka Producer Queue - KafkaPublishPatientSnapshot");
        }
    }
}