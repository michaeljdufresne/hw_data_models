<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 12:54
 */

namespace Edumedics\DataModels\Events\EmailCampaigns;


use Edumedics\DataModels\Eloquent\EmailCampaigns;
use Edumedics\DataModels\Events\Event;

class EmailCampaignDelete extends Event
{
    /**
     * @var EmailCampaigns
     */
    public $emailCampaign;

    /**
     * EmailCampaignDelete constructor.
     * @param EmailCampaigns $emailCampaign
     */
    public function __construct(EmailCampaigns $emailCampaign)
    {
        $this->emailCampaign = $emailCampaign;
    }
}