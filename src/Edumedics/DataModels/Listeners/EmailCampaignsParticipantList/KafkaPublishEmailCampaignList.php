<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 13:43
 */

namespace Edumedics\DataModels\Listeners\EmailCampaignsParticipantList;

use Edumedics\DataModels\Events\EmailCampaignParticipantList\EmailCampaignParticipantListDelete;
use Edumedics\DataModels\Events\EmailCampaignParticipantList\EmailCampaignParticipantListUpdate;
use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishEmailCampaignList extends ListenerAppResolver
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
                if ($eventType == EmailCampaignParticipantListDelete::class)
                {
                    $eventCopy->emailCampaignsParticipantList = $eventCopy->emailCampaignsParticipantList->toArray();
                }
                elseif ($eventType == EmailCampaignParticipantListUpdate::class)
                {
                    $customAttributes['changedAttributes'] = $event->emailCampaignsParticipantList->getDirty();
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