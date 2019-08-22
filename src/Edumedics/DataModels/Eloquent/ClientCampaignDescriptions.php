<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\ClientCampaignDescriptions\ClientCampaignDescriptionsCreate;
use Edumedics\DataModels\Events\ClientCampaignDescriptions\ClientCampaignDescriptionsUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ClientCampaignDescriptions extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'client_campaign_descriptions';

    /**
     * @var array
     */
    protected $fillable = ['client_id','campaign_description'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ClientCampaignDescriptionsCreate::class,
        'updated' => ClientCampaignDescriptionsUpdate::class
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campaigns(){
        return $this->hasMany('Edumedics\DataModels\Eloquent\Campaigns', 'client_campaign_description_id', 'id');
    }

}