<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-02
 * Time: 14:58
 */

namespace Edumedics\DataModels\Events\PatientDiagnoses;


use Edumedics\DataModels\Eloquent\PatientDiagnoses;
use Edumedics\DataModels\Events\Event;

class PatientDiagnosesCreate extends Event
{
    /**
     * @var PatientDiagnoses
     */
    public $patientDiagnoses;

    /**
     * PatientDiagnosesCreate constructor.
     * @param PatientDiagnoses $patientDiagnoses
     */
    public function __construct(PatientDiagnoses $patientDiagnoses)
    {
        $this->patientDiagnoses = $patientDiagnoses;
    }

}