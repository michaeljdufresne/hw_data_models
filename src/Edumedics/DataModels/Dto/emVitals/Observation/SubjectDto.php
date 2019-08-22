<?php


namespace Edumedics\DataModels\Dto\emVitals\Observation;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class SubjectDto
 * @package Edumedics\DataModels\Dto\emVitals\Observation
 */
class SubjectDto extends Dto
{

    /**
     * @var IdentifierDto[]
     */
    public $identifier;

    /**
     * @var NameDto
     */
    public $name;

    /**
     * @var TelecomDto[]
     */
    public $telecom;

    /**
     * @var string
     */
    public $birthDate;

    /**
     * @var string
     */
    public $gender;

    /**
     * @var ManagingOrganizationDto
     */
    public $managingOrganization;

    /**
     * @var array
     */
    protected $fillable = [ 'identifier', 'name', 'telecom', 'birthDate', 'gender', 'managingOrganization' ];

    /**
     * @param null $dataArray
     * @return mixed|void
     */
    public function populate($dataArray = null)
    {
        if (isset($dataArray) && is_array($dataArray))
        {
            foreach ($dataArray as $k => $v)
            {
                switch ($k)
                {
                    case 'identifier':
                        $this->{$k} = [];
                        foreach ($v as $identifier) {
                            $identifierDto = new IdentifierDto();
                            $identifierDto->populate($identifier);
                            $this->{$k}[] = $identifierDto;
                        }
                        break;

                    case 'name':
                        $nameDto = new NameDto();
                        $nameDto->populate($v);
                        $this->{$k} = $nameDto;
                        break;

                    case 'telecom':
                        $this->{$k} = [];
                        foreach ($v as $telecom) {
                            $telecomDto = new TelecomDto();
                            $telecomDto->populate($telecom);
                            $this->{$k}[] = $telecomDto;
                        }
                        break;

                    case 'managingOrganization':
                        $managingOrganizationDto = new ManagingOrganizationDto();
                        $managingOrganizationDto->populate($v);
                        $this->{$k} = $managingOrganizationDto;
                        break;

                    default:
                        $this->{$k} = $v;
                        break;
                }
            }
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'identifier' => $this->jsonSerializeArray($this->identifier),
            'name' => $this->name,
            'telecom' =>  $this->jsonSerializeArray($this->telecom),
            'birthDate' => $this->birthDate,
            'gender' => $this->gender,
            'managingOrganization' => $this->jsonSerializeObject($this->managingOrganization)
        ];
    }
}