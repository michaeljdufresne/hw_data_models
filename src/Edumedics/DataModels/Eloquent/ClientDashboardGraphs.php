<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 10/3/18
 * Time: 11:51 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class ClientDashboardGraphs extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'client_dashboard_graphs';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function graph(){
        return $this->belongsTo('Edumedics\DataModels\Eloquent\HealthwardGraphs');
    }

}