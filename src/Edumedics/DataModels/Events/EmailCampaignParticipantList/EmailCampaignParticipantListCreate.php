<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 13:35
 */

namespace Edumedics\DataModels\Events\EmailCampaignParticipantList;


use Edumedics\DataModels\Eloquent\EmailCampaignsParticipantList;
use Edumedics\DataModels\Events\EmailCampaigns\EmailCampaignDelete;
use Edumedics\DataModels\Events\Event;

class EmailCampaignParticipantListCreate extends Event
{
    /**
     * @var EmailCampaignsParticipantList
     */
    public $emailCampaignsParticipantList;

    /**
     * EmailCampaignParticipantListCreate constructor.
     * @param EmailCampaignsParticipantList $emailCampaignsParticipantList
     */
    public function __construct(EmailCampaignsParticipantList $emailCampaignsParticipantList)
    {
        $this->emailCampaignsParticipantList = $emailCampaignsParticipantList;
    }
}