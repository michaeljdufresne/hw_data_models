<?php

namespace Edumedics\DataModels\Events\Program;


use Edumedics\DataModels\Eloquent\Program;
use Edumedics\DataModels\Events\Event;

class ProgramUpdate extends Event
{
    /**
     * @var Program
     */
    public $program;

    /**
     * ProgramUpdate constructor.
     * @param Program $program
     */
    public function __construct(Program $program)
    {
        $this->program = $program;
    }
}