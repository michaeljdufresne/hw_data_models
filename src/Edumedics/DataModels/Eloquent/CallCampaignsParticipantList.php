<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 5/3/19
 * Time: 9:35 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListCreate;
use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListDelete;
use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListUpdate;
use Edumedics\DataModels\Scopes\OmitArchivedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CallCampaignsParticipantList extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'call_campaigns_participant_list';

    /**
     * @var array
     */
    protected $fillable = ['call_campaign_id','task_id','is_completed','patient_id'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CallCampaignsParticipantListCreate::class,
        'updated' => CallCampaignsParticipantListUpdate::class,
        'deleting' => CallCampaignsParticipantListDelete::class
    ];

    public $appends = ['has_call_campaign_logs'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function callCampaign(){
        return $this->hasOne('Edumedics\DataModels\Eloquent\CallCampaigns', 'id', 'call_campaign_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient(){
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient','_id','patient_id')
            ->withoutGlobalScope(OmitArchivedScope::class);
    }

    public function getHasCallCampaignLogsAttribute()
    {
        $campaign = CallCampaigns::find($this->call_campaign_id);
        $logs = PatientCommunicationLog::where('patient_id', $this->patient_id)->where('campaign_id',$campaign->campaign_id)
            ->where('communication', 3)->count();

        if($logs > 0){
            return true;
        } else {
            return false;
        }
    }

}