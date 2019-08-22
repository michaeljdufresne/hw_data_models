<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 5/2/19
 * Time: 9:42 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\Events\CallCampaigns\CallCampaignCreate;
use Edumedics\DataModels\Events\CallCampaigns\CallCampaignDelete;
use Edumedics\DataModels\Events\CallCampaigns\CallCampaignUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CallCampaigns extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'call_campaigns';

    /**
     * @var array
     */
    protected $fillable = ['campaign_id','start_date','end_date','status','status_reason'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CallCampaignCreate::class,
        'updated' => CallCampaignUpdate::class,
        'deleting' => CallCampaignDelete::class
    ];

    /**
     * @var array
     */
    public $appends = ['status_text'];

    /**
     * @var array
     */
    protected $statusDescription = [
        1 => 'Not Generated',
        2 => 'Generated',
        3 => 'Assigned',
        4 => 'Started',
        5 => 'Completed',
        6 => 'Cancelled'
    ];

    /**
     * @return mixed
     */
    public function getStatusTextAttribute()
    {
        return $this->statusDescription[$this->status];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function campaign(){
        return $this->hasOne('Edumedics\DataModels\Eloquent\Campaigns', 'id', 'campaign_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function callCampaignParticipantList(){
        return $this->hasMany('Edumedics\DataModels\Eloquent\CallCampaignsParticipantList', 'call_campaign_id', 'id');
    }

}