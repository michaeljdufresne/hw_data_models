<?php


namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\ViimedProgramPathwayAssignment\ViimedPathwayAssignmentCreate;
use Edumedics\DataModels\Events\ViimedProgramPathwayAssignment\ViimedPathwayAssignmentDelete;
use Edumedics\DataModels\Events\ViimedProgramPathwayAssignment\ViimedPathwayAssignmentUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ViimedProgramPathwayAssignment extends Model
{

    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';
    /**
     * @var string
     */
    protected $table = 'viimed_program_pathway_assignment';

    /**
     * @var array
     */
    protected $appends = [ 'programName', 'initialCompletedValue' ];

    /**
     * @var array
     */
    public static $programType = [
        1 => 'act2',
        2 => 'DECIDE'
    ];

    /**
     * @var array
     */
    public static $initialCompletedValue = [
        1 => 0,
        2 => 1
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ViimedPathwayAssignmentCreate::class,
        'updated' => ViimedPathwayAssignmentUpdate::class,
        'deleting' => ViimedPathwayAssignmentDelete::class
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient', '_id', 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function enrollment()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\ParticipantProgramEnrollment',
            'id', 'healthward_participant_program_enrollment_id');
    }

    /**
     * @return mixed
     */
    public function getProgramNameAttribute()
    {
        return ViimedProgramPathwayAssignment::$programType[$this->program_type];
    }

    /**
     * @return mixed
     */
    public function getInitialCompletedValueAttribute()
    {
        return ViimedProgramPathwayAssignment::$initialCompletedValue[$this->program_type];
    }
}