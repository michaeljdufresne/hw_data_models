<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 13:00
 */

namespace Edumedics\DataModels\Events\MailCampaigns;


use Edumedics\DataModels\Eloquent\MailCampaigns;
use Edumedics\DataModels\Events\Event;

class MailCampaignUpdate extends Event
{
    public $mailCampaign;

    public function __construct(MailCampaigns $mailCampaign)
    {
        $this->mailCampaign = $mailCampaign;
    }
}