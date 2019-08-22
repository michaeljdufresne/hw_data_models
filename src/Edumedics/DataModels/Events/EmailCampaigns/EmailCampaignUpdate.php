<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 13:02
 */

namespace Edumedics\DataModels\Events\EmailCampaigns;


use Edumedics\DataModels\Eloquent\EmailCampaigns;
use Edumedics\DataModels\Events\Event;

class EmailCampaignUpdate extends Event
{
    /**
     * @var EmailCampaigns
     */
    public $emailCampaign;

    /**
     * EmailCampaignUpdate constructor.
     * @param EmailCampaigns $emailCampaign
     */
    public function __construct(EmailCampaigns $emailCampaign)
    {
        $this->emailCampaign = $emailCampaign;
    }
}