<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 6/13/18
 * Time: 3:26 PM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class SupportLibraryDocuments extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'support_library_documents';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assignedLibrary(){
        return $this->hasMany('Edumedics\DataModels\Eloquent\SupportLibraryDocumentsAssignment','support_library_document_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document(){
        return $this->belongsTo('Edumedics\DataModels\Eloquent\Document');
    }

}