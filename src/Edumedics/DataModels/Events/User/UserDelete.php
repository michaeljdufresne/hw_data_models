<?php


namespace Edumedics\DataModels\Events\User;


use Edumedics\DataModels\Eloquent\User;
use Edumedics\DataModels\Events\Event;

class UserDelete extends Event
{
    /**
     * @var User
     */
    public $user;

    /**
     * UserCreate constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}