<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 13:40
 */

namespace Edumedics\DataModels\Events\EmailCampaignParticipantList;


use Edumedics\DataModels\Eloquent\EmailCampaignsParticipantList;
use Edumedics\DataModels\Events\Event;

class EmailCampaignParticipantListDelete extends Event
{
    /**
     * @var EmailCampaignsParticipantList
     */
    public $emailCampaignsParticipantList;

    /**
     * EmailCampaignParticipantListUpdate constructor.
     * @param EmailCampaignsParticipantList $emailCampaignsParticipantList
     */
    public function __construct(EmailCampaignsParticipantList $emailCampaignsParticipantList)
    {
        $this->emailCampaignsParticipantList = $emailCampaignsParticipantList;
    }
}