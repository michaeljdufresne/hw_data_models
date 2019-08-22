<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-07-12
 * Time: 13:46
 */

namespace Edumedics\DataModels\Events\Notifications;


use Edumedics\DataModels\Eloquent\Notifications;
use Edumedics\DataModels\Events\Event;

class NotificationUpdate extends Event
{
    /**
     * @var Notifications
     */
    public $notification;

    /**
     * NotificationCreate constructor.
     * @param Notifications $notification
     */
    public function __construct(Notifications $notification)
    {
        $this->notification = $notification;
    }

}