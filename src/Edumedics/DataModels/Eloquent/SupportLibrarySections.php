<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 6/11/18
 * Time: 12:36 PM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;


class SupportLibrarySections extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'support_library_sections';

    /**
     * @var array
     */
    public static $libraries = [
        1 => 'Internal Library',
        2 => 'External Library'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subSections()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\SupportLibrarySubSections','section_id','id')->orderBy('order','ASC');
    }

    /**
     * @return mixed
     */
    public function activeSubsections()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\SupportLibrarySubSections','section_id','id')->active()->orderBy('order','ASC');
    }
}