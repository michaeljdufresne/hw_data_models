<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 7/8/19
 * Time: 11:42 AM
 */

namespace Edumedics\DataModels\Events\Notifications;


use Edumedics\DataModels\Eloquent\Notifications;
use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Traits\TenantConnectorTrait;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BroadcastNotifications extends Event implements ShouldBroadcast
{
    use TenantConnectorTrait;

    /**
     * @var string
     */
    public $connection = 'broadcast';

    /**
     * @var string
     */
    public $envConfig;

    /**
     * @var Notifications
     */
    public $notification;

    /**
     * BroadcastNotifications constructor.
     * @param Notifications $notification
     * @param $envConfig
     */
    public function __construct(Notifications $notification, $envConfig)
    {
        $this->notification = $notification;
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
        return new PrivateChannel('user.'.$this->notification->user_id);
    }
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'notifications';
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
        // We need to get the count of active notifications and the list of active
        // notifications as an array

        $data = [
            'count' => Notifications::where('user_id',$this->notification->user_id)->notAcknowledged()->count(),
            'notifications' => Notifications::where('user_id',$this->notification->user_id)->notAcknowledged()->with('notificationType')->get()
        ];

        return $data;
    }

}