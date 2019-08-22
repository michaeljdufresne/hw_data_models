<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 13:01
 */

namespace Edumedics\DataModels\Events\EmailCampaigns;


use Edumedics\DataModels\Eloquent\EmailCampaigns;
use Edumedics\DataModels\Events\Event;

class EmailCampaignCreate extends Event
{
    /**
     * @var EmailCampaigns
     */
    public $emailCampaign;

    /**
     * EmailCampaignCreate constructor.
     * @param EmailCampaigns $emailCampaign
     */
    public function __construct(EmailCampaigns $emailCampaign)
    {
        $this->emailCampaign = $emailCampaign;
    }
}