<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 3/20/19
 * Time: 9:28 AM
 */

namespace Edumedics\DataModels\Events\ClientPrograms;


use Edumedics\DataModels\Eloquent\ClientsPrograms;
use Edumedics\DataModels\Events\Event;

class ClientProgramsUpdate extends Event
{
    /**
     * @var clientsPrograms
     */
    public $clientsPrograms;

    /**
     * ClientProgramsCreate constructor.
     * @param ClientsPrograms $clientsPrograms
     */
    public function __construct(ClientsPrograms $clientsPrograms)
    {
        $this->clientsPrograms = $clientsPrograms;
    }

}