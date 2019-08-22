<?php

namespace Edumedics\DataModels\Eloquent;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    protected $connection = 'pgsql';

}