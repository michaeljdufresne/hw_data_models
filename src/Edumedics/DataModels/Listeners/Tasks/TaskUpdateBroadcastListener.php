<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 11/29/18
 * Time: 11:34 AM
 */

namespace Edumedics\DataModels\Listeners\Tasks;

use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Events\Tasks\BroadcastOutstandingTask;
use Edumedics\DataModels\Events\Tasks\TaskUpdate;

class TaskUpdateBroadcastListener
{


    /**
     * Handle the event.
     *
     * @param  TaskUpdate  $event
     * @return void
     */
    public function handle(TaskUpdate $event)
    {
        $task = $event->task;

        $changedAttributes = $task->getDirty();
        if (isset($changedAttributes['assigned_user_id']))
        {
            // increase and/or decrease new assigned user id tasks and previous assigned user id tasks
            event( new BroadcastOutstandingTask($task, null, Event::getEnvConfig()) );
            $previousTask = $task->getOriginal();
            event( new BroadcastOutstandingTask($task, $previousTask, Event::getEnvConfig()) );
        }
        else {
            event( new BroadcastOutstandingTask($task, null, Event::getEnvConfig()) );
        }
    }

}