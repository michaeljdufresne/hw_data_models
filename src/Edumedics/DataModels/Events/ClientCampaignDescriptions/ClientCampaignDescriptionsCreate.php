<?php

namespace Edumedics\DataModels\Events\ClientCampaignDescriptions;

use Edumedics\DataModels\Eloquent\ClientCampaignDescriptions;
use Edumedics\DataModels\Events\Event;

class ClientCampaignDescriptionsCreate extends Event
{

    /**
     * @var ClientCampaignDescriptions
     */
    public $clientCampaignDescriptions;

    /**
     * ClientCampaignDescriptionsCreate constructor.
     * @param ClientCampaignDescriptions $clientCampaignDescriptions
     */
    public function __construct(ClientCampaignDescriptions $clientCampaignDescriptions)
    {
        $this->clientCampaignDescriptions = $clientCampaignDescriptions;
    }

}