<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 8/21/18
 * Time: 9:48 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class LandingPageDocuments extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'landing_page_documents';

    /**
     * @var array
     */
    protected $guarded = ['id'];

}