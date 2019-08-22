<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ClientDocuments extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'client_documents';

    /**
     * @var array
     */
    protected $fillable = ['client_id','document_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function document(){
        return $this->hasOne('Edumedics\DataModels\Eloquent\Document', 'id', 'document_id');
    }

}