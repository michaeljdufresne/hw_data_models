<?php


namespace Edumedics\DataModels\Events\Tasks;

use Edumedics\DataModels\Eloquent\Tasks;
use Edumedics\DataModels\Events\Event;

class TaskDelete extends Event
{
    /**
     * @var Tasks
     */
    public $task;

    /**
     * TaskCreate constructor.
     * @param Tasks $task
     */
    public function __construct(Tasks $task)
    {
        $this->task = $task;
    }
}