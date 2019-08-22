<?php


namespace Edumedics\DataModels\Events\Client;

use Edumedics\DataModels\Eloquent\Client;
use Edumedics\DataModels\Events\Event;

class ClientUnarchive extends Event
{
    /**
     * @var Client
     */
    public $client;

    /**
     * ClientUnarchive constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}