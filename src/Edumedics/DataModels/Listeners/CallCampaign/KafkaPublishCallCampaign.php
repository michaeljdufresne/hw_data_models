<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-03
 * Time: 13:58
 */

namespace Edumedics\DataModels\Listeners\CallCampaign;


use Edumedics\DataModels\Events\CallCampaigns\CallCampaignDelete;
use Edumedics\DataModels\Events\CallCampaigns\CallCampaignUpdate;
use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishCallCampaign extends ListenerAppResolver
{
    use KafkaTopicMapTrait;

    /**
     * KafkaPublishCallCampaign constructor.
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

                $eventCopy = Event::deepCopy($event);
                $customAttributes = [];
                $eventType = get_class($event);

                if($eventType == CallCampaignDelete::class)
                {
                    $eventCopy->callCampaign = $eventCopy->callCampaign->toArray();
                }
                elseif($eventType == CallCampaignUpdate::class)
                {
                    $customAttributes['changedAttributes'] = $event->callCampaign->getDirty();
                }

                $this->resolvedService->kafkaProducerQueue->push($this->getTopic($eventType),
                    new EventTransferModel(Event::getEnvConfig(),$eventType, $eventCopy, $customAttributes)
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