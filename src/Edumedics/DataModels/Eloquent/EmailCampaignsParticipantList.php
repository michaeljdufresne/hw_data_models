<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 5/3/19
 * Time: 9:43 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\Events\EmailCampaignParticipantList\EmailCampaignParticipantListCreate;
use Edumedics\DataModels\Events\EmailCampaignParticipantList\EmailCampaignParticipantListDelete;
use Edumedics\DataModels\Events\EmailCampaignParticipantList\EmailCampaignParticipantListUpdate;
use Edumedics\DataModels\Scopes\OmitArchivedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EmailCampaignsParticipantList extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'email_campaigns_participant_list';

    /**
     * @var array
     */
    protected $fillable = ['email_campaign_id','patient_id'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => EmailCampaignParticipantListCreate::class,
        'updated' => EmailCampaignParticipantListUpdate::class,
        'deleting' => EmailCampaignParticipantListDelete::class
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emailCampaign(){
        return $this->hasOne('Edumedics\DataModels\Eloquent\EmailCampaigns', 'id', 'email_campaign_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient(){
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient','_id','patient_id')
            ->withoutGlobalScope(OmitArchivedScope::class);
    }
}