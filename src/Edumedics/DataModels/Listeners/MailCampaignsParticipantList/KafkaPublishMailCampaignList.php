<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 13:46
 */

namespace Edumedics\DataModels\Listeners\MailCampaignsParticipantList;


use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Events\MailCampaignParticipantList\MailCampaignParticipantListDelete;
use Edumedics\DataModels\Events\MailCampaignParticipantList\MailCampaignParticipantListUpdate;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishMailCampaignList extends ListenerAppResolver
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
                if ($eventType == MailCampaignParticipantListDelete::class)
                {
                    $eventCopy->mailCampaignsParticipantList = $eventCopy->mailCampaignsParticipantList->toArray();
                }
                elseif ($eventType == MailCampaignParticipantListUpdate::class)
                {
                    $customAttributes['changedAttributes'] = $event->mailCampaignsParticipantList->getDirty();
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