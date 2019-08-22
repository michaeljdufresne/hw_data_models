<?php


namespace Edumedics\DataModels\Events\ViimedProgramPathwayAssignment;


use Edumedics\DataModels\Eloquent\ViimedProgramPathwayAssignment;
use Edumedics\DataModels\Events\Event;


class ViimedPathwayAssignmentCreate extends Event
{

    /**
     * @var ViimedProgramPathwayAssignment
     */
    public $viimedProgramPathwayAssignment;

    /**
     * ViimedPathwayAssignmentCreate constructor.
     * @param ViimedProgramPathwayAssignment $viimedProgramPathwayAssignment
     */
    public function __construct(ViimedProgramPathwayAssignment $viimedProgramPathwayAssignment)
    {
        $this->viimedProgramPathwayAssignment = $viimedProgramPathwayAssignment;
    }
}