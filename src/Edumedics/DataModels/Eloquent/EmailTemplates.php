<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 5/2/19
 * Time: 11:47 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class EmailTemplates extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'email_templates';

}