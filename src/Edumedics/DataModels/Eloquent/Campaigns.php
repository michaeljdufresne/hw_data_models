<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 5/2/19
 * Time: 9:25 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\Events\Campaigns\CampaignCreate;
use Edumedics\DataModels\Events\Campaigns\CampaignDelete;
use Edumedics\DataModels\Events\Campaigns\CampaignUpdate;
use Edumedics\DataModels\Scopes\OmitArchivedScope;
//use Edumedics\EmailCampaigns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Campaigns extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'campaigns';

    /**
     * @var array
     */
    protected $fillable = ['name','client_id','client_campaign_description_id','cost'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CampaignCreate::class,
        'updated' => CampaignUpdate::class,
        'deleting' => CampaignDelete::class
    ];

    /**
     * @var array
     */
    public $appends = ['checked_campaign_types','can_edit','can_delete','campaign_documents'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OmitArchivedScope());
    }

    /**
     *
     */
    public function archive()
    {
        $this->archived = true;
        $this->save();
    }

    /**
     *
     */
    public function unarchive()
    {
        $this->archived = false;
        $this->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client(){
        return $this->hasOne('Edumedics\DataModels\Eloquent\Client', 'id', 'client_id')
            ->withoutGlobalScope(OmitArchivedScope::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function description(){
        return $this->hasOne('Edumedics\DataModels\Eloquent\ClientCampaignDescriptions', 'id', 'client_campaign_description_id');
    }

    /**
     * @return mixed
     */
    public function callCampaign()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\CallCampaigns','campaign_id','id');
    }

    /**
     * @return mixed
     */
    public function emailCampaign()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\EmailCampaigns','campaign_id','id');
    }

    /**
     * @return mixed
     */
    public function mailCampaign()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\MailCampaigns','campaign_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        // returns actual campaign to document relationship
        return $this->hasMany('Edumedics\DataModels\Eloquent\CampaignDocuments','campaign_id','id')->with('document');
    }

    /**
     * @return mixed
     */
    public function getCampaignDocumentsAttribute()
    {
        // only document ids
        return CampaignDocuments::where('campaign_id',$this->id)->pluck('document_id')->toArray();
    }

    /**
     * @return array
     */
    public function getCanEditAttribute(){
        $callCampaign = CallCampaigns::where('campaign_id', $this->id)->first();
        $emailCampaign = EmailCampaigns::where('campaign_id', $this->id)->first();
        $mailCampaign = MailCampaigns::where('campaign_id',$this->id)->first();
        $canEdit = true;
        if(isset($callCampaign)){
            if($callCampaign->status > 2){
                $canEdit = false;
            }
        }
        if(isset($emailCampaign)){
            if($emailCampaign->status > 2){
                $canEdit = false;
            }
        }
        if(isset($mailCampaign)){
            if($mailCampaign->status > 2){
                $canEdit = false;
            }
        }
        return ['status' => $canEdit];
    }

    /**
     * @return array
     */
    public function getCanDeleteAttribute(){
        $callCampaign = CallCampaigns::where('campaign_id', $this->id)->first();
        $emailCampaign = EmailCampaigns::where('campaign_id', $this->id)->first();
        $mailCampaign = MailCampaigns::where('campaign_id',$this->id)->first();
        $canDelete = true;
        if(isset($callCampaign)){
            if($callCampaign->status > 2){
                $canDelete = false;
            }
        }
        if(isset($emailCampaign)){
            if($emailCampaign->status > 2){
                $canDelete = false;
            }
        }
        if(isset($mailCampaign)){
            if($mailCampaign->status > 2){
                $canDelete = false;
            }
        }
        return ['status' => $canDelete];
    }

    /**
     * @return array
     */
    public function getCheckedCampaignTypesAttribute()
    {
        $checkedTypes = [];
        $callCampaign = CallCampaigns::where('campaign_id', $this->id)->first();
        $emailCampaign = EmailCampaigns::where('campaign_id', $this->id)->first();
        $mailCampaign = MailCampaigns::where('campaign_id',$this->id)->first();

        if(isset($callCampaign)){
            array_push($checkedTypes, 1);
        }
        if(isset($emailCampaign)){
            array_push($checkedTypes, 2);
        }
        if(isset($mailCampaign)){
            array_push($checkedTypes, 3);
        }
        return $checkedTypes;
    }

}