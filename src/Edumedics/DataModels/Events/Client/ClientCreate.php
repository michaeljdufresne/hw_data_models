<?php

namespace Edumedics\DataModels\Events\Client;

use Edumedics\DataModels\Eloquent\Client;
use Edumedics\DataModels\Events\Event;

class ClientCreate extends Event
{

    /**
     * @var Client
     */
    public $client;

    /**
     * ClientCreate constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

}