<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 12:58
 */

namespace Edumedics\DataModels\Events\MailCampaigns;


use Edumedics\DataModels\Eloquent\MailCampaigns;
use Edumedics\DataModels\Events\Event;

class MailCampaignCreate extends Event
{
    /**
     * @var MailCampaigns
     */
    public $mailCampaign;

    /**
     * MailCampaignCreate constructor.
     * @param MailCampaigns $mailCampaign
     */
    public function __construct(MailCampaigns $mailCampaign)
    {
        $this->mailCampaign = $mailCampaign;
    }
}