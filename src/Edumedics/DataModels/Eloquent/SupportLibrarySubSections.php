<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 6/13/18
 * Time: 9:46 AM
 */

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class SupportLibrarySubSections extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'support_library_subsections';

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

}