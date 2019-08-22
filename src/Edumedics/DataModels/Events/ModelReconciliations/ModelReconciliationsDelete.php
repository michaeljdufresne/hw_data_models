<?php

namespace Edumedics\DataModels\Events\ModelReconciliations;

use Edumedics\DataModels\Eloquent\ModelReconciliations;
use Edumedics\DataModels\Events\Event;

class ModelReconciliationsDelete extends Event
{
    /**
     * @var ModelReconciliations
     */
    public $modelReconciliation;

    /**
     * ModelReconciliationsDelete constructor.
     * @param ModelReconciliations $modelReconciliation
     */
    public function __construct(ModelReconciliations $modelReconciliation)
    {
        $this->modelReconciliation = $modelReconciliation;
    }
}