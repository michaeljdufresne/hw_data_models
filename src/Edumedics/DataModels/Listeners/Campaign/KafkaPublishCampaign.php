<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-03
 * Time: 14:01
 */

namespace Edumedics\DataModels\Listeners\Campaign;


use Edumedics\DataModels\Events\Campaigns\CampaignDelete;
use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishCampaign extends ListenerAppResolver
{
    use KafkaTopicMapTrait;

    /**
     * KafkaPublishCampaign constructor.
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

                $eventType = get_class($eventCopy);
                if ($eventType == CampaignDelete::class)
                {
                    $eventCopy->campaign = $eventCopy->campaign->toArray();
                }

                $this->resolvedService->kafkaProducerQueue->push($this->getTopic($eventType),
                    new EventTransferModel(Event::getEnvConfig(),get_class($eventCopy), $eventCopy)
                );
            }
            catch (\Exception $e)
            {
                Log::info("Produce call campaign update to Kafka failed: " . $e->getMessage());
            }
        }
        else
        {
            Log::info("Unable to resolve KafkaProxyService or find Kafka Producer Queue - KafkaPublishCallCampaign");
        }
    }

}