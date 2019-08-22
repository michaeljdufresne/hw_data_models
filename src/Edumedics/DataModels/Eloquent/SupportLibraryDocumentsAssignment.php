<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 6/13/18
 * Time: 3:27 PM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class SupportLibraryDocumentsAssignment extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'support_library_documents_assignment';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supportLibraryDocument(){
        return $this->belongsTo('Edumedics\DataModels\Eloquent\SupportLibraryDocuments');
    }

}