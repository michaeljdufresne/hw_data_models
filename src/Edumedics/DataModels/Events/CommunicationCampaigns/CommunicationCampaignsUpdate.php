<?php

namespace Edumedics\DataModels\Events\CommunicationCampaigns;

use Edumedics\DataModels\Eloquent\CommunicationCampaigns;
use Edumedics\DataModels\Events\Event;

class CommunicationCampaignsUpdate extends Event
{
    // TODO remove
    /**
     * @var CommunicationCampaigns
     */
    public $communicationCampaign;

    /**
     * CommunicationCampaignsUpdate constructor.
     * @param CommunicationCampaigns $communicationCampaign
     */
    public function __construct(CommunicationCampaigns $communicationCampaign)
    {
        $this->communicationCampaign = $communicationCampaign;
    }
}