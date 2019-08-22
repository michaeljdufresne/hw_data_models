<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 9/7/18
 * Time: 11:17 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class HealthwardGraphs extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'healthward_graphs';
}