<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 6/22/18
 * Time: 12:20 PM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class EmbeddedHelpContent extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'embedded_help_content';

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

}