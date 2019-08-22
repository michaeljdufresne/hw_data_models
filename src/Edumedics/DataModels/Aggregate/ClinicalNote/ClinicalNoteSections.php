<?php
/**
 * Created by IntelliJ IDEA.
 * User: Martha Hidalgo
 * Date: 3/15/2018
 * Time: 10:02 AM
 */

namespace Edumedics\DataModels\Aggregate\ClinicalNote;

use Edumedics\DataModels\DrChrono\ClinicalNotes\ClinicalNoteSection;
use Illuminate\Database\Eloquent\Model;


class ClinicalNoteSections extends Model
{
    /**
     * @var string
     */
    protected $table = 'drchrono_clinical_note_sections';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var array
     */
    protected $clinicalNoteSectionFields = [
        'clinical_note_template', 'name', 'freetext_note'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany('Edumedics\DataModels\Aggregate\ClinicalNote\ClinicalNoteSectionValues','clinical_note_section_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinicalNote()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\ClinicalNote', 'clinical_note_id', '_id');
    }

    /**
     * @param ClinicalNoteSection $clinicalNoteSection
     */
    public function populate(ClinicalNoteSection $clinicalNoteSection)
    {
        foreach ($this->clinicalNoteSectionFields as $k)
        {
            if(isset($clinicalNoteSection->{$k}))
            {
                $this->{$k} = $clinicalNoteSection->{$k};
            }
        }
    }
}