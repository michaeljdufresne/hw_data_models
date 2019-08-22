<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 13:11
 */

namespace Edumedics\DataModels\Listeners\EmailCampaign;


use Edumedics\DataModels\Events\EmailCampaigns\EmailCampaignDelete;
use Edumedics\DataModels\Events\EmailCampaigns\EmailCampaignUpdate;
use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishEmailCampaign extends ListenerAppResolver
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

                if($eventType == EmailCampaignDelete::class)
                {
                    $eventCopy->emailCampaign = $eventCopy->emailCampaign->toArray();
                }
                elseif($eventType == EmailCampaignUpdate::class)
                {
                    $customAttributes['changedAttributes'] = $event->emailCampaign->getDirty();
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