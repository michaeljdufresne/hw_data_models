<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-06
 * Time: 13:55
 */

namespace Edumedics\DataModels\Events\CallCampaignsParticipantList;


use Edumedics\DataModels\Eloquent\CallCampaignsParticipantList;
use Edumedics\DataModels\Events\Event;

class CallCampaignsParticipantListDelete extends Event
{
    /**
     * @var CallCampaignsParticipantList
     */
    public $callCampaignsParticipantList;

    /**
     * CallCampaignsParticipantListDelete constructor.
     * @param CallCampaignsParticipantList $callCampaignsParticipantList
     */
    public function __construct(CallCampaignsParticipantList $callCampaignsParticipantList)
    {
        $this->callCampaignsParticipantList = $callCampaignsParticipantList;
    }
}