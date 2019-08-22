<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-03
 * Time: 13:21
 */

namespace Edumedics\DataModels\Listeners\CallCampaignsParticipantList;

use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListDelete;
use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListUpdate;
use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishCallList extends ListenerAppResolver
{
    use KafkaTopicMapTrait;

    /**
     * KafkaPublishCallList constructor.
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
                if ($eventType == CallCampaignsParticipantListDelete::class)
                {
                    $eventCopy->callCampaignsParticipantList = $eventCopy->callCampaignsParticipantList->toArray();
                }
                elseif ($eventType == CallCampaignsParticipantListUpdate::class)
                {
                    $changedFields = $event->callCampaignsParticipantList->getDirty();
                    $previousValuesOfChangedFields = [];
                    foreach($changedFields as $k => $v)
                    {
                        $previousValuesOfChangedFields[$k] = $event->callCampaignsParticipantList->getOriginal($k);
                    }
                    $customAttributes['changedAttributes'] = $previousValuesOfChangedFields;//$event->callCampaignsParticipantList->getDirty();
                }

                $this->resolvedService->kafkaProducerQueue->push($this->getTopic($eventType),
                    new EventTransferModel(Event::getEnvConfig(),$eventType, $eventCopy, $customAttributes)
                );
            }
            catch (\Exception $e)
            {
                Log::info("Produce Campaign Call List to Kafka failed: " . $e->getMessage());
            }
        }
        else
        {
            Log::info("Unable to resolve KafkaProxyService or find Kafka Producer Queue - KafkaPublishCallList");
        }
    }

}