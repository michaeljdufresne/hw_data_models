<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 3/20/19
 * Time: 9:38 AM
 */

namespace Edumedics\DataModels\Listeners\ClientPrograms;


use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Illuminate\Support\Facades\Log;
use SentryHealth\Kafka\Models\EventTransferModel;
use Edumedics\DataModels\Events\ClientPrograms\ClientProgramsUpdate;

class KafkaPublishClientProgram extends ListenerAppResolver
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
                if ($eventType == ClientProgramsUpdate::class)
                {
                    $this->resolvedService->kafkaProducerQueue->push($this->getTopic($eventType),
                        new EventTransferModel(Event::getEnvConfig(),get_class($event), $event, ['changedAttributes' => $event->clientsPrograms->getDirty()])
                    );
                }
                else
                {
                    $this->resolvedService->kafkaProducerQueue->push($this->getTopic($eventType),
                        new EventTransferModel(Event::getEnvConfig(),get_class($event), $event)
                    );
                }


            }
            catch (\Exception $e)
            {
                Log::info("Produce ClientPrograms to Kafka failed: " . $e->getMessage());
            }
        }
        else
        {
            Log::info("Unable to resolve KafkaProxyService or find Kafka Producer Queue - KafkaPublishClientPrograms");
        }

    }

}