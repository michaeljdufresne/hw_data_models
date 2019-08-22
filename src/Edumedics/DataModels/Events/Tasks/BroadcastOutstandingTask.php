<?php

namespace Edumedics\DataModels\Events\Tasks;


use Edumedics\DataModels\Eloquent\Tasks;
use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Traits\TenantConnectorTrait;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BroadcastOutstandingTask extends Event implements ShouldBroadcast
{

    use TenantConnectorTrait;
    /**
     * @var Tasks
     */
    public $task;

    /**
     * @var null
     */
    public $previousTask;

    /**
     * @var string
     */
    public $envConfig;

    /**
     * BroadcastOutstandingTask constructor.
     * @param Tasks $task
     * @param null $previousTask
     * @param $envConfig
     */
    public function __construct(Tasks $task, $previousTask = null, $envConfig)
    {
        $this->task = $task;
        $this->previousTask = $previousTask;
        $this->envConfig = $envConfig;
    }

    /**
     *
     */
    public function __wakeup()
    {
        $this->setTenantConnection($this->envConfig);
        parent::__wakeup();
    }


    /**
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]|PrivateChannel
     */
    public function broadcastOn()
    {
        if(isset($this->previousTask))
        {
            return new PrivateChannel('user.'.$this->previousTask['assigned_user_id']);
        }

        return new PrivateChannel('user.'.$this->task->assigned_user_id);
    }
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'outstanding-tasks';
    }

    /**
     * Determine if this event should broadcast.
     *
     * @return bool
     */
    public function broadcastWhen()
    {
        return true;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        if(isset($this->previousTask))
        {
            $data = [ 'count' => Tasks::where(['assigned_user_id' => $this->previousTask['assigned_user_id'], 'is_active' => true, 'archived' => false])
                ->whereNull('deleted_at')->whereNull('completed_at')->count()
            ];
        }
        else {
            $data = [ 'count' => Tasks::where(['assigned_user_id' => $this->task->assigned_user_id, 'is_active' => true, 'archived' => false])
                ->whereNull('deleted_at')->whereNull('completed_at')->count()
            ];
        }

        return $data;
    }

}