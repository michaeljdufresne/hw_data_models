<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 5/30/19
 * Time: 5:34 PM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class ClientSlugEnvConfigMap extends Model
{
    /**
     * @var string
     */
    protected $table = 'client_slug_env_config_map';

    /**
     * @var string
     */
    protected $connection = 'pgsql';

}