<?php


namespace Edumedics\DataModels\Dto\emVitals;


use Edumedics\DataModels\Dto\Common\PatientDto;
use Edumedics\DataModels\Dto\Dto;

/**
 * Class PatientRequestDto
 * @package Edumedics\DataModels\Dto\emVitals
 */
class EmVitalsPatientRequestDto extends Dto
{

    /**
     * @var string
     */
    public $organization;

    /**
     * @var string
     */
    public $clientName;

    /**
     * @var string
     */
    public $userName;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $patientid;

    /**
     * @var boolean
     */
    public $activateAccount;

    /**
     * @var PatientDto
     */
    public $patient;

    /**
     * @var array
     */
    protected $fillable = [
        'organization', 'clientName', 'userName', 'password', 'patientid', 'activateAccount', 'patient'
    ];

    /**
     * @param null $dataArray
     * @return mixed|void
     */
    public function populate($dataArray = null) {}

}