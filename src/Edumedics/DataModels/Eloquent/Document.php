<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Document extends Model {

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'documents';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'location',
        'extension',
        'user_id',
        'belongs_to_user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Edumedics\DataModels\Eloquent\User');
    }

    public function belongs_to_user()
    {
        return $this->belongsTo('Edumedics\DataModels\Eloquent\User', 'id', 'belongs_to_user_id');
    }

}