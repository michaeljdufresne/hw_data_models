<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 5/2/19
 * Time: 10:11 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\Events\EmailCampaigns\EmailCampaignCreate;
use Edumedics\DataModels\Events\EmailCampaigns\EmailCampaignDelete;
use Edumedics\DataModels\Events\EmailCampaigns\EmailCampaignUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EmailCampaigns extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'email_campaigns';

    /**
     * @var array
     */
    protected $fillable = ['campaign_id','email_date','email','status','status_reason'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => EmailCampaignCreate::class,
        'updated' => EmailCampaignUpdate::class,
        'deleting' => EmailCampaignDelete::class
    ];

    /**
     * @var array
     */
    public $appends = ['status_text','email_content'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email' => 'array'
    ];

    /**
     * @var array
     */
    protected $statusDescription = [
        1 => 'Not Generated',
        2 => 'Generated',
        3 => 'Completed',
        4 => 'Cancelled'
    ];

    public function getEmailContentAttribute(){
        return ['body' => $this->email];
    }

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
    public function emailCampaignParticipantList(){
        return $this->hasMany('Edumedics\DataModels\Eloquent\EmailCampaignsParticipantList', 'email_campaign_id', 'id');
    }

}