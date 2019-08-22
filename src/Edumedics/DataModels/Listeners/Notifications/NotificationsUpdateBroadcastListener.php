<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 7/12/19
 * Time: 3:35 PM
 */

namespace Edumedics\DataModels\Listeners\Notifications;

use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Events\Notifications\BroadcastNotifications;
use Edumedics\DataModels\Events\Notifications\NotificationUpdate;

class NotificationsUpdateBroadcastListener
{
    public function handle(NotificationUpdate $event)
    {
        $notification = $event->notification;
        event( new BroadcastNotifications($notification, Event::getEnvConfig()) );
    }

}