<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-03
 * Time: 09:10
 */

namespace Edumedics\DataModels\Events\CallCampaigns;


use Edumedics\DataModels\Eloquent\CallCampaigns;
use Edumedics\DataModels\Events\Event;

class CallCampaignUpdate extends Event
{
    /**
     * @var CallCampaigns
     */
    public $callCampaign;

    /**
     * CallCampaignUpdate constructor.
     * @param CallCampaigns $callCampaign
     */
    public function __construct(CallCampaigns $callCampaign)
    {
        $this->callCampaign = $callCampaign;
    }

}