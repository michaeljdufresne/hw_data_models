<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 5/3/19
 * Time: 9:41 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\Events\MailCampaignParticipantList\MailCampaignParticipantListCreate;
use Edumedics\DataModels\Events\MailCampaignParticipantList\MailCampaignParticipantListDelete;
use Edumedics\DataModels\Events\MailCampaignParticipantList\MailCampaignParticipantListUpdate;
use Edumedics\DataModels\Scopes\OmitArchivedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MailCampaignsParticipantList extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'mail_campaigns_participant_list';

    /**
     * @var array
     */
    protected $fillable = ['mail_campaign_id','patient_id'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => MailCampaignParticipantListCreate::class,
        'updated' => MailCampaignParticipantListUpdate::class,
        'deleting' => MailCampaignParticipantListDelete::class
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mailCampaign(){
        return $this->hasOne('Edumedics\DataModels\Eloquent\MailCampaigns', 'id', 'mail_campaign_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient(){
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient','_id','patient_id')
            ->withoutGlobalScope(OmitArchivedScope::class);
    }

}