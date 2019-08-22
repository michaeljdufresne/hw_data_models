<?php

namespace Edumedics\DataModels\Aggregate;

use Illuminate\Database\Eloquent\Model;

class LineItem extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_line_items';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var array
     */
    protected $dates = ['service_date', 'posted_date'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'modifiers' => 'array',
        'diagnosis_pointers' => 'array'
    ];


    /**
     * @param $drChronoLineItem
     * @throws \Exception
     */
    public function populate($drChronoLineItem)
    {
        foreach ($drChronoLineItem as $k => $v)
        {
            switch ($k)
            {
                case 'id':
                    $this->drchrono_line_item_id = (int)$v;
                    break;

                case 'service_date':
                    $this->service_date = new \DateTime($v);
                    break;

                case 'posted_date':
                    $this->posted_date = new \DateTime($v);
                    break;

                case 'appointment':
                    $this->appointment = (string)$v;
                    break;

                default:
                    $this->{$k} = $v;
            }
        }
    }

}