<?php


namespace Edumedics\DataModels\Dto\emVitals;


use Edumedics\DataModels\Dto\Dto;
use Edumedics\DataModels\Dto\emVitals\Observation\CategoryDto;
use Edumedics\DataModels\Dto\emVitals\Observation\ComponentDto;
use Edumedics\DataModels\Dto\emVitals\Observation\IdentifierDto;
use Edumedics\DataModels\Dto\emVitals\Observation\InterpretationDto;
use Edumedics\DataModels\Dto\emVitals\Observation\MethodDto;
use Edumedics\DataModels\Dto\emVitals\Observation\PerformerDto;
use Edumedics\DataModels\Dto\emVitals\Observation\SubjectDto;
use Edumedics\DataModels\Dto\emVitals\Observation\ValueAttachmentDto;

/**
 * Class ObservationDto
 * @package Edumedics\DataModels\Dto\emVitals
 */
class ObservationDto extends Dto
{

    /**
     * @var string
     */
    public $resourceType;

    /**
     * @var IdentifierDto[]
     */
    public $identifier;

    /**
     * @var string
     */
    public $status;

    /**
     * @var CategoryDto[]
     */
    public $category;

    /**
     * @var SubjectDto
     */
    public $subject;

    /**
     * @var \DateTime
     */
    public $issued;

    /**
     * @var PerformerDto[]
     */
    public $performer;

    /**
     * @var ValueAttachmentDto
     */
    public $valueAttachment;

    /**
     * @var MethodDto
     */
    public $method;

    /**
     * @var ComponentDto[]
     */
    public $component;

    /**
     * @var InterpretationDto
     */
    public $interpretation;

    /**
     * @var array
     */
    protected $fillable = [ 'resourceType', 'identifier', 'status', 'category', 'subject', 'issued', 'performer',
        'valueAttachment', 'method', 'component', 'interpretation' ];

    /**
     * @param null $dataArray
     * @return mixed|void
     * @throws \Exception
     */
    public function populate($dataArray = null)
    {
        if (isset($dataArray) && is_array($dataArray))
        {
            foreach ($dataArray as $k => $v)
            {
                switch ($k)
                {
                    case 'resourceType':
                    case 'status':
                        $this->{$k} = $v;
                        break;

                    case 'issued':
                        $this->{$k} = new \DateTime($v);
                        break;

                    case 'identifier':
                        $this->{$k} = [];
                        foreach ($v as $identifier) {
                            $identifierDto = new IdentifierDto();
                            $identifierDto->populate($identifier);
                            $this->{$k}[] = $identifierDto;
                        }
                        break;

                    case 'category':
                        $this->{$k} = [];
                        foreach ($v as $category) {
                            $categoryDto = new CategoryDto();
                            $categoryDto->populate($category);
                            $this->{$k}[] = $categoryDto;
                        }
                        break;

                    case 'subject':
                        $subjectDto = new SubjectDto();
                        $subjectDto->populate($v);
                        $this->{$k} = $subjectDto;
                        break;

                    case 'performer':
                        $this->{$k} = [];
                        foreach ($v as $performer) {
                            $performerDto = new PerformerDto();
                            $performerDto->populate($performer);
                            $this->{$k}[] = $performerDto;
                        }
                        break;

                    case 'valueAttachment':
                        $valueAttachmentDto = new ValueAttachmentDto();
                        $valueAttachmentDto->populate($v);
                        $this->{$k} = $valueAttachmentDto;
                        break;

                    case 'method':
                        $methodDto = new MethodDto();
                        $methodDto->populate($v);
                        $this->{$k} = $methodDto;
                        break;

                    case 'component':
                        $this->{$k} = [];
                        foreach ($v as $component) {
                            $componentDto = new ComponentDto();
                            $componentDto->populate($component);
                            $this->{$k}[] = $componentDto;
                        }
                        break;

                    case 'interpretation':
                        $interpretationDto = new InterpretationDto();
                        $interpretationDto->populate($v);
                        $this->{$k} = $interpretationDto;
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
            'resourceType' => $this->resourceType,
            'identifier' => $this->jsonSerializeArray($this->identifier),
            'status' => $this->status,
            'category' => $this->jsonSerializeArray($this->category),
            'subject' => $this->jsonSerializeObject($this->subject),
            'issued' => $this->formatDateTime($this->issued),
            'performer' => $this->jsonSerializeArray($this->performer),
            'valueAttachment' => $this->jsonSerializeObject($this->valueAttachment),
            'method' => $this->jsonSerializeObject($this->method),
            'component' => $this->jsonSerializeArray($this->component),
            'interpretation' => $this->jsonSerializeObject($this->interpretation)
        ];
    }

}