<?php


namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class ShipCredentials extends Model
{

    use Encryptable;

    /**
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * @var string
     */
    protected $table = 'ship_credentials';

    /**
     * @var array
     */
    protected $encrypted = [ 'ship_username', 'ship_password' ];

}