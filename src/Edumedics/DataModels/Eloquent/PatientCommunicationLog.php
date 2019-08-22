<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\PatientCommunicationLog\PatientCommunicationLogCreate;
use Edumedics\DataModels\Events\PatientCommunicationLog\PatientCommunicationLogDelete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PatientCommunicationLog extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';
    /**
     * @var string
     */
    protected $table = 'patient_communication_log';

    /**
     * @var array
     */
    protected $fillable = ['patient_id','user_id','duration','communication_reason','campaign_id','communication','notes'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PatientCommunicationLogCreate::class,
        'deleting' => PatientCommunicationLogDelete::class
    ];

    /**
     * @var array
     */
    public static $communicationReasons = [
        1 => 'Campaign',
        2 => 'Call',
        3 => 'Email',
        4 => 'Critical Value',
        5 => 'Other'
    ];

    /**
     * @var array
     */
    public static $communicationActions = [
        1 => 'Email Sent',
        2 => 'Mail Sent',
        3 => 'Phone Call Out',
        4 => 'Email Failed',
        5 => 'Email Received',
        6 => 'Phone Call In',
        7 => 'Other'
    ];

    /**
     * @var array
     */
    public static $selectableCommunicationActions = [
        1 => 'Email Sent',
        3 => 'Phone Call Out',
        5 => 'Email Received',
        6 => 'Phone Call In'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\User', 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function campaign()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Campaigns', 'id', 'campaign_id')->with(['emailCampaign','mailCampaign','documents']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\PatientCommunicationResults','communication_log_id','id')
            ->with(['task']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function task()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Tasks', 'id', 'task_id');
    }
}