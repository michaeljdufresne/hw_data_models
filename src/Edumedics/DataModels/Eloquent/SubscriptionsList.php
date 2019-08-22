<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-06-21
 * Time: 14:00
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class SubscriptionsList extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'subscriptions_list';

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}