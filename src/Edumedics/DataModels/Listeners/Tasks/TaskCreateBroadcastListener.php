<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 11/28/18
 * Time: 4:13 PM
 */

namespace Edumedics\DataModels\Listeners\Tasks;

use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Events\Tasks\BroadcastOutstandingTask;
use Edumedics\DataModels\Events\Tasks\TaskCreate;

class TaskCreateBroadcastListener
{


    public function handle(TaskCreate $event)
    {
        $task = $event->task;
        event( new BroadcastOutstandingTask($task, null, Event::getEnvConfig()) );
    }

}