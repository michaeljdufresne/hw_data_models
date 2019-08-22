<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-05-10
 * Time: 07:42
 */

namespace Edumedics\DataModels\Events\CollaborativeMDAudits;


use Edumedics\DataModels\Eloquent\CollaborativeMdAudit;
use Edumedics\DataModels\Events\Event;

class CollaborativeMDAuditCreate extends Event
{
    /**
     * @var CollaborativeMdAudit
     */
    public $collaborativeMDAudit;

    /**
     * CollaborativeMDAuditCreate constructor.
     * @param CollaborativeMdAudit $collaborativeMDAudit
     */
    public function __construct(CollaborativeMdAudit $collaborativeMDAudit)
    {
        $this->collaborativeMDAudit = $collaborativeMDAudit;
    }

}