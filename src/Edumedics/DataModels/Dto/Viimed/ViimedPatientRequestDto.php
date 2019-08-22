<?php


namespace Edumedics\DataModels\Dto\Viimed;


use Edumedics\DataModels\Dto\Common\PatientDto;
use Edumedics\DataModels\Dto\Dto;

/**
 * Class PatientRequestDto
 * @package Edumedics\DataModels\Dto\emVitals
 */
class ViimedPatientRequestDto extends Dto
{

    /**
     * @var string
     */
    public $token;

    /**
     * @var string
     */
    public $organizationId;

    /**
     * @var PatientDto
     */
    public $patient;

    /**
     * @var array
     */
    protected $fillable = [
        'token', 'organizationId','patient'
    ];

    /**
     * @param null $dataArray
     * @return mixed|void
     */
    public function populate($dataArray = null) {}

}