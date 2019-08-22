<?php

namespace Edumedics\DataModels\Events\LabResultView;

use Edumedics\DataModels\Aggregate\LabResultView;
use Edumedics\DataModels\Events\Event;

class LabResultViewCreate extends Event
{
    public $labResultView;

    /**
     * Create a new event instance.
     *
     * @param LabResultView $labResultView
     */
    public function __construct(LabResultView $labResultView)
    {
        $labResultView->loadMissing('drchrono_patient');
        $this->labResultView = $labResultView;
    }
}