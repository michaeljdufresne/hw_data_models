<?php
/**
 * Created by IntelliJ IDEA.
 * User: Martha Hidalgo
 * Date: 3/15/2018
 * Time: 10:51 AM
 */

namespace Edumedics\DataModels\Events\ClinicalNote;

use Edumedics\DataModels\Aggregate\ClinicalNote;
use Edumedics\DataModels\Events\Event;

class ClinicalNoteUpdate extends Event
{
    public $clinicalNote;

    public function __construct(ClinicalNote $clinicalNote)
    {
        $clinicalNote->loadMissing('drchrono_patient');
        $this->clinicalNote = $clinicalNote;
    }

}