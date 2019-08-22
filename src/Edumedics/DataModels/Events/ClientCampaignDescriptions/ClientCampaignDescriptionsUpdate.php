<?php

namespace Edumedics\DataModels\Events\ClientCampaignDescriptions;

use Edumedics\DataModels\Eloquent\ClientCampaignDescriptions;
use Edumedics\DataModels\Events\Event;

class ClientCampaignDescriptionsUpdate extends Event
{
    /**
     * @var ClientCampaignDescriptions
     */
    public $clientCampaignDescriptions;

    /**
     * ClientCampaignDescriptionsUpdate constructor.
     * @param ClientCampaignDescriptions $clientCampaignDescriptions
     */
    public function __construct(ClientCampaignDescriptions $clientCampaignDescriptions)
    {
        $this->clientCampaignDescriptions = $clientCampaignDescriptions;
    }
}