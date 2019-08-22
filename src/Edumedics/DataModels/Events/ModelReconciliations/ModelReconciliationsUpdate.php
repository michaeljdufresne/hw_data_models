<?php

namespace Edumedics\DataModels\Events\ModelReconciliations;

use Edumedics\DataModels\Eloquent\ModelReconciliations;
use Edumedics\DataModels\Events\Event;

class ModelReconciliationsUpdate extends Event
{
    /**
     * @var ModelReconciliations
     */
    public $modelReconciliation;

    /**
     * ModelReconciliationsUpdate constructor.
     * @param ModelReconciliations $modelReconciliation
     */
    public function __construct(ModelReconciliations $modelReconciliation)
    {
        $this->modelReconciliation = $modelReconciliation;
    }

}