<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 12:51
 */

namespace Edumedics\DataModels\Events\CallCampaigns;


use Edumedics\DataModels\Eloquent\CallCampaigns;
use Edumedics\DataModels\Events\Event;

class CallCampaignDelete extends Event
{
    /**
     * @var CallCampaigns
     */
    public $callCampaign;

    /**
     * CallCampaignDelete constructor.
     * @param CallCampaigns $callCampaign
     */
    public function __construct(CallCampaigns $callCampaign)
    {
        $this->callCampaign = $callCampaign;
    }
}