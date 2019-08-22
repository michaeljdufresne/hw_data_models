<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    public $table = "course";

    /**
     * @var array
     */
    protected $guarded = ['id'];

}