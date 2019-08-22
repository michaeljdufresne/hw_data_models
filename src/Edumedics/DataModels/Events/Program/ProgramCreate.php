<?php

namespace Edumedics\DataModels\Events\Program;


use Edumedics\DataModels\Eloquent\Program;
use Edumedics\DataModels\Events\Event;

class ProgramCreate extends Event
{
    /**
     * @var Program
     */
    public $program;

    /**
     * ProgramCreate constructor.
     * @param Program $program
     */
    public function __construct(Program $program)
    {
        $this->program = $program;
    }
}