<?php

namespace Edumedics\DataModels\Aggregate;

use Edumedics\DataModels\DrChrono\LabOrders;
use Edumedics\DataModels\Events\Lab\LabCreate;
use Edumedics\DataModels\Events\Lab\LabDelete;
use Edumedics\DataModels\Events\Lab\LabUpdate;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lab
 * @package Edumedics\DataModels\Aggregate
 */
class Lab extends Model
{
    /**
     * @var string
     */
    protected $table = 'drchrono_labs';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $primaryKey = '_id';

    /**
     * @var array
     */
    protected $labOrderFields = [
        'id', 'sublab', 'doctor', 'patient', 'documents', 'timestamp', 'status', 'icd10_codes',
        'requisition_id', 'accession_number', 'notes', 'priority'
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => LabCreate::class,
        'updated' => LabUpdate::class,
        'deleting' => LabDelete::class
    ];

    /**
     * @var array
     */
    protected $dates = ['timestamp'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'documents' => 'array',
        'icd10_codes' => 'array'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labTest()
    {
        return $this->hasMany('Edumedics\DataModels\Aggregate\Lab\LabTest', 'lab_order', 'drchrono_lab_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labResults()
    {
        return $this->hasMany('Edumedics\DataModels\Aggregate\Lab\LabResult', 'lab_order', 'drchrono_lab_id');
    }


    /**
     * @param LabOrders $labOrder
     */
    public function populate(LabOrders $labOrder)
    {
        foreach ($this->labOrderFields as $k)
        {
            if (isset($labOrder->{$k}))
            {
                switch ($k)
                {
                    case 'id':
                        $this->drchrono_lab_id = (int)$labOrder->{$k};
                        break;

                    case 'icd10_codes':
                        $codeArray = [];
                        $icd10CodeObjects = $labOrder->{$k};
                        foreach ($icd10CodeObjects as $icd10CodeObject)
                        {
                            if (isset($icd10CodeObject->code))
                            {
                                $codeArray[] = $icd10CodeObject->code;
                            }
                        }
                        $this->icd10_codes = $codeArray;

                    default:
                        $this->{$k} = $labOrder->{$k};
                }
            }
        }
    }
}