<?php


namespace Edumedics\DataModels\Events\Audit;

use Edumedics\DataModels\Eloquent\AuditHttpRequest;
use Edumedics\DataModels\Events\Event;

class AuditHttpRequestEvent Extends Event
{
    /**
     * @var
     */
    public $httpRequestData;

    /**
     * AuditHttpRequestEvent constructor.
     * @param $httpRequestData
     */
    public function __construct(AuditHttpRequest $httpRequestData)
    {
        $this->httpRequestData = $httpRequestData;
    }

}