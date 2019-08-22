<?php

namespace Edumedics\DataModels\Aggregate\ClinicalNote;

use Edumedics\DataModels\DrChrono\ClinicalNotes\ClinicalNoteSectionFieldValues;
use Illuminate\Database\Eloquent\Model;

class ClinicalNoteSectionValues extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_clinical_note_section_values';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';


    /**
     * @var array
     */
    protected $clinicalNoteSectionFieldValues = [
        'id','clinical_note_field','value', 'appointment'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\ClinicalNote\ClinicalNoteSections','clinical_note_section_id', 'id');
    }

    /**
     * @param ClinicalNoteSectionFieldValues $clinicalNoteSectionFieldValues
     */
    public function populate(ClinicalNoteSectionFieldValues $clinicalNoteSectionFieldValues)
    {
        foreach ($this->clinicalNoteSectionFieldValues as $k)
        {
            if(isset($clinicalNoteSectionFieldValues->{$k}))
            {
                switch ($k)
                {
                    case 'id':
                        $this->drchrono_clinical_note_value_id = (int)$clinicalNoteSectionFieldValues->{$k};
                        break;

                    case 'appointment':
                        $this->drchrono_clinical_note_value_id = (string)$clinicalNoteSectionFieldValues->{$k};
                        break;

                    default:
                        $this->{$k} = $clinicalNoteSectionFieldValues->{$k};
                }
            }
        }
    }
}