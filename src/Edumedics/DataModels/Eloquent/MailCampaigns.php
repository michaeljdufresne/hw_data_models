<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 5/2/19
 * Time: 10:05 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\Events\MailCampaigns\MailCampaignCreate;
use Edumedics\DataModels\Events\MailCampaigns\MailCampaignDelete;
use Edumedics\DataModels\Events\MailCampaigns\MailCampaignUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MailCampaigns extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'mail_campaigns';

    /**
     * @var array
     */
    protected $fillable = ['campaign_id','mail_date','status','status_reason'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => MailCampaignCreate::class,
        'updated' => MailCampaignUpdate::class,
        'deleting' => MailCampaignDelete::class
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
        3 => 'Completed',
        4 => 'Cancelled'
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
    public function mailCampaignParticipantList(){
        return $this->hasMany('Edumedics\DataModels\Eloquent\MailCampaignsParticipantList', 'mail_campaign_id', 'id');
    }
}