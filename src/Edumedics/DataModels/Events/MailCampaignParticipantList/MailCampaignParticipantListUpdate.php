<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 13:50
 */

namespace Edumedics\DataModels\Events\MailCampaignParticipantList;


use Edumedics\DataModels\Eloquent\MailCampaignsParticipantList;
use Edumedics\DataModels\Events\Event;

class MailCampaignParticipantListUpdate extends Event
{
    /**
     * @var MailCampaignsParticipantList
     */
    public $mailCampaignsParticipantList;

    /**
     * MailCampaignParticipantListCreate constructor.
     * @param MailCampaignsParticipantList $mailCampaignsParticipantList
     */
    public function __construct(MailCampaignsParticipantList $mailCampaignsParticipantList)
    {
        $this->mailCampaignsParticipantList = $mailCampaignsParticipantList;
    }
}