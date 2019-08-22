<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-08
 * Time: 13:20
 */

namespace Edumedics\DataModels\Events\Campaigns;


use Edumedics\DataModels\Eloquent\Campaigns;
use Edumedics\DataModels\Events\Event;

class CampaignUpdate extends Event
{
    /**
     * @var Campaigns
     */
    public $campaign;

    /**
     * CampaignDelete constructor.
     * @param Campaigns $campaign
     */
    public function __construct(Campaigns $campaign)
    {
        $this->campaign = $campaign;
    }

}