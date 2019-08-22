<?php

namespace Edumedics\DataModels\Listeners\Audit;

use Edumedics\DataModels\Events\Audit\AuditHttpRequestEvent;
use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishHttpRequestAudit extends ListenerAppResolver
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
     * @param AuditHttpRequestEvent $event
     */
    public function handle(AuditHttpRequestEvent $event)
    {
        if (isset($this->resolvedService) && isset($this->resolvedService->kafkaProducerQueue))
        {
            try
            {
                $eventType = get_class($event);
                $event->httpRequestData = $event->httpRequestData->toArray();

                $this->resolvedService->kafkaProducerQueue->push($this->getTopic($eventType),
                    new EventTransferModel(Event::getEnvConfig(),$eventType, $event)
                );
            }
            catch (\Exception $e)
            {
                Log::info("Produce Http Request Audit to Kafka failed: " . $e->getMessage());
            }
        }
        else
        {
            Log::info("Unable to resolve KafkaProxyService or find Kafka Producer Queue - KafkaPublishHttpRequestAudit");
        }

    }
}