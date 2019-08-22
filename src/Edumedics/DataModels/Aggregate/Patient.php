<?php

namespace Edumedics\DataModels\Aggregate;

use Carbon\Carbon;
use Edumedics\DataModels\DrChrono\Patients;
use Edumedics\DataModels\Dto\Common\ExternalIdDto;
use Edumedics\DataModels\Dto\Common\Patient\PatientInsuranceDto;
use Edumedics\DataModels\Dto\Common\PatientDto;
use Edumedics\DataModels\Eloquent\CallCampaigns;
use Edumedics\DataModels\Eloquent\CallCampaignsParticipantList;
use Edumedics\DataModels\Eloquent\CampaignsCallList;
use Edumedics\DataModels\Eloquent\CommunicationCampaigns;
use Edumedics\DataModels\Eloquent\EmailCampaigns;
use Edumedics\DataModels\Eloquent\EmailCampaignsParticipantList;
use Edumedics\DataModels\Eloquent\FlaggedDuplicatePatients;
use Edumedics\DataModels\Eloquent\MailCampaigns;
use Edumedics\DataModels\Eloquent\MailCampaignsParticipantList;
use Edumedics\DataModels\Events\Patient\PatientArchive;
use Edumedics\DataModels\Events\Patient\PatientCreate;
use Edumedics\DataModels\Events\Patient\PatientDelete;
use Edumedics\DataModels\Events\Patient\PatientUnarchive;
use Edumedics\DataModels\Events\Patient\PatientUpdate;
use Edumedics\DataModels\MapTraits\PatientDataMapTrait;
use Edumedics\DataModels\Scopes\OmitArchivedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class Patient extends Model
{

    use Notifiable, PatientDataMapTrait;

    /**
     * @var
     */
    public $usersApiToken;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $primaryKey = '_id';

    /**
     * @var string
     */
    protected $table = 'patients';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var array
     */
    protected $dates = ['date_of_birth', 'archived_at'];

    /**
     * @var array
     */
    protected $insuranceFields = [
        'insurance_company', 'insurance_id_number', 'insurance_group_number'
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PatientCreate::class,
        'updated' => PatientUpdate::class,
        'deleting' => PatientDelete::class
    ];

    /**
     * @var array
     */
    public static $employeeTypes = [ 1=>'EMPLOYEE', 2=>'SPOUSE', 3=>'DEPENDANT', 4=>'RETIREE', 5=>'DOMESTIC PARTNER', 6=>'OTHER'];

    /**
     * @var array
     */
    public static $externalIdTempMap = [
        ExternalIdDto::DrChronoId => 'drchrono_patient_id',
        ExternalIdDto::NavMdId => 'navmd_id'
    ];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OmitArchivedScope());
        static::creating(function ($model) {
            $model->_id = Uuid::uuid4()->toString();
        });
    }


    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        if(in_array($key, ['first_name','middle_name','last_name','nick_name','maiden_name'])){
            $this->setAttribute($key, strtoupper($value));
        }else{
            $this->setAttribute($key,$value);
        }
    }

    /**
     * @param $usersApiToken
     */
    public function bindUsersApiToken($usersApiToken = null)
    {
        $this->usersApiToken = $usersApiToken;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eligibilities()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\ParticipantProgramEligibility', 'patient_id', '_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrollments()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\ParticipantProgramEnrollment', 'patient_id', '_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function riskProfiles()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\PatientRiskProfile', 'patient_id', '_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function riskProfilesAscending()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\PatientRiskProfile', 'patient_id', '_id')->orderBy('created_at', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patientSnapshot()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\PatientSnapshot', 'patient_id', '_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patientSubscriptions()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\PatientSubscriptions', 'patient_id', '_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alerts()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\PatientAlerts', 'patient_id', '_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patientClients()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\PatientsClients', 'patient_id', '_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patientDiagnoses()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\PatientDiagnoses','patient_id', '_id');
    }

    /**
     * @return string
     */
    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     *
     */
    public function activeCampaign()
    {
        $this->active_campaign = false;
        $callCampaigns = CallCampaignsParticipantList::where('patient_id',$this->_id)->pluck('call_campaign_id')->toArray();
        $mailCampaigns = MailCampaignsParticipantList::where('patient_id',$this->_id)->pluck('mail_campaign_id')->toArray();
        $emailCampaigns = EmailCampaignsParticipantList::where('patient_id',$this->_id)->pluck('email_campaign_id')->toArray();

        $callCampaignStatus = CallCampaigns::whereIn('id',$callCampaigns)->where('status','<',5)->count();
        $mailCampaignStatus = MailCampaigns::whereIn('id',$mailCampaigns)->where('status','<',3)->count();
        $emailCampaignStatus = EmailCampaigns::whereIn('id',$emailCampaigns)->where('status','<',3)->count();

        if($callCampaignStatus > 0 || $mailCampaignStatus > 0 || $emailCampaignStatus > 0){
            $this->active_campaign = true;
        }
    }

    /**
     *
     */
    public function archive()
    {
        $this->archived = true;
        $this->archived_at = new \DateTime();
        $this->save();
        event(new PatientArchive($this));
    }

    /**
     *
     */
    public function unarchive()
    {
        $this->archived = false;
        $this->save();
        event(new PatientUnarchive($this));
    }

    /**
     * @param array $patientData
     * @param Patients $drChronoPatient
     */
    public function populate(array $patientData = null, Patients $drChronoPatient = null)
    {
        if (!empty($patientData))
        {
            foreach (Patient::$HealthwardPatientDataFields as $k)
            {
                if (isset($patientData[$k]))
                {
                    switch ($k)
                    {
                        case 'client_id':
                            $this->client_id = (int)$patientData[$k];
                            break;

                        default:
                            $this->{$k} = $patientData[$k];
                    }
                }
            }
        }

        if (isset($drChronoPatient))
        {
            if (isset($drChronoPatient->id))
            {
                $this->drchrono_patient_id = (int)$drChronoPatient->id;
            }
            foreach (Patient::$DrChronoPatientDataFields as $k)
            {
                if (isset($drChronoPatient->{$k}))
                {
                    switch ($k)
                    {
                        case 'primary_insurance':
                            $insurance = $drChronoPatient->{$k};
                            foreach ($this->insuranceFields as $insuranceField)
                            {
                                $this->{$insuranceField} = $insurance->{$insuranceField};
                            }
                            break;

                        case 'custom_demographics':
                            $customDemographics = $drChronoPatient->{$k};
                            $patientNoteCode = (env('APP_ENV') == 'prod') ? 6542 : 8278;
                            $maidenNameCode = (env('APP_ENV') == 'prod') ? 12157 : 12156;
                            foreach ($customDemographics as $customDemographic)
                            {
                                if ($customDemographic->field_type == $patientNoteCode)
                                {
                                    $this->patient_notes = $customDemographic->value;
                                }
                                else if ($customDemographic->field_type == $maidenNameCode)
                                {
                                    $this->maiden_name = $customDemographic->value;
                                }
                            }
                            break;

                        default:
                            $this->{$k} = $drChronoPatient->{$k};
                    }
                }
            }
        }
    }

    /**
     * @param PatientDto $patientDto
     */
    public function populateFromDto(PatientDto $patientDto)
    {
        foreach ($patientDto as $k => $v)
        {
            switch ($k)
            {
                // TODO Update PatientIdMap event if external ids change
                case 'external_ids':
                    foreach ($v as $externalId)
                    {
                        if (isset(Patient::$externalIdTempMap[$externalId->type]))
                        {
                            $this->{Patient::$externalIdTempMap[$externalId->type]} = $externalId->id;
                        }
                    }
                    break;

                case 'doctor_id':
                    $this->doctor = $v;
                    break;

                case 'primary_insurance':
                case 'secondary_insurance':
                case 'tertiary_insurance':
                    if (!empty($v))
                    {
                        if ($k == 'primary_insurance'
                            || ($k == 'secondary_insurance'
                                && !isset($patientDto->primary_insurance))
                            || ($k == 'tertiary_insurance'
                                && !isset($patientDto->primary_insurance)
                                && !isset($patientDto->secondary_insurance))
                        )
                        {
                            foreach ($this->insuranceFields as $insuranceField)
                            {
                                $this->{$insuranceField} = $v->{$insuranceField};
                            }
                        }
                    }
                    break;

                default:
                    $this->{$k} = $v;
            }
        }
    }

}