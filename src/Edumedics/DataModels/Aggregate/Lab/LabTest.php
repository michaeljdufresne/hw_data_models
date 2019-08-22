<?php

namespace Edumedics\DataModels\Aggregate\Lab;

use Edumedics\DataModels\DrChrono\LabTests;
use Illuminate\Database\Eloquent\Model;


class LabTest extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_lab_tests';

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
    protected $dates = ['collection_date'];

    /**
     * @var array
     */
    protected $labTestFields = [
        'id', 'lab_order', 'name', 'description', 'collection_date', 'internal_notes', 'report_notes',
        'status', 'specimen_source', 'specimen_condition', 'specimen_total_volume'
    ];

    /**
     * @param LabTests $labTest
     */
    public function populate(LabTests $labTest)
    {
        foreach ($this->labTestFields as $k)
        {
            if (isset($labTest->{$k}))
            {
                switch ($k)
                {
                    case 'id':
                        $this->drchrono_lab_test_id = (int)$labTest->{$k};
                        break;

                    default:
                        $this->{$k} = $labTest->{$k};
                }
            }
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lab()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\Lab', 'lab_order', 'drchrono_lab_id');
    }

}