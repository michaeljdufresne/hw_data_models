<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 11/29/18
 * Time: 11:50 AM
 */

namespace Edumedics\DataModels\Listeners\Tasks;

use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Events\Tasks\BroadcastOutstandingTask;
use Edumedics\DataModels\Events\Tasks\TaskDelete;

class TaskDeleteBroadcastListener
{


    public function handle(TaskDelete $event)
    {
        $task = $event->task;
        event( new BroadcastOutstandingTask($task, null, Event::getEnvConfig()) );
    }

}