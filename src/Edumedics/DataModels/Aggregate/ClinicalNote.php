<?php
/**
 * Created by IntelliJ IDEA.
 * User: Martha Hidalgo
 * Date: 3/15/2018
 * Time: 9:39 AM
 */

namespace Edumedics\DataModels\Aggregate;

use Edumedics\DataModels\DrChrono\ClinicalNotes;
use Edumedics\DataModels\Events\ClinicalNote\ClinicalNoteCreate;
use Edumedics\DataModels\Events\ClinicalNote\ClinicalNoteDelete;
use Edumedics\DataModels\Events\ClinicalNote\ClinicalNoteUpdate;
use Illuminate\Database\Eloquent\Model;

class ClinicalNote extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_clinical_notes';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $primaryKey = '_id';

    /**
     * @var array
     */
    protected $clinicalNoteFields = [
        'archived', 'appointment', 'patient'
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ClinicalNoteCreate::class,
        'updated' => ClinicalNoteUpdate::class,
        'deleted' => ClinicalNoteDelete::class
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clinicalNoteSections()
    {
        return $this->hasMany('Edumedics\DataModels\Aggregate\ClinicalNote\ClinicalNoteSections', 'clinical_note_id', '_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drchrono_patient()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient', 'drchrono_patient_id', 'patient');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drChronoAppointment()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Appointment', 'drchrono_appointment_id', 'appointment');
    }

    /**
     * @param ClinicalNotes $clinicalNote
     */
    public function populate(ClinicalNotes $clinicalNote)
    {
        foreach ($this->clinicalNoteFields as $k)
        {
            if(isset($clinicalNote->{$k}))
            {
                if ($k == 'appointment')
                {
                    $this->{$k} = (string)$clinicalNote->{$k};
                }
                else
                {
                    $this->{$k} = $clinicalNote->{$k};
                }
            }
        }
    }

}