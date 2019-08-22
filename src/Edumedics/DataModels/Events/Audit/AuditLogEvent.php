<?php


namespace Edumedics\DataModels\Events\Audit;

use Edumedics\DataModels\Eloquent\AuditLog;
use Edumedics\DataModels\Events\Event;

class AuditLogEvent extends Event
{

    /**
     * @var AuditLog
     */
    public $auditLog;

    /**
     * AuditLogEvent constructor.
     * @param AuditLog $auditLog
     */
    public function __construct(AuditLog $auditLog)
    {
        $this->auditLog = $auditLog;
    }

}