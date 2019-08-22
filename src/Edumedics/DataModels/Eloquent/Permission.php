<?php

namespace Edumedics\DataModels\Eloquent;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{

    protected $connection = 'pgsql';

}