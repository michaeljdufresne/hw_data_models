<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class CollaborativeMdAssignment extends Model {

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    public $table = 'collaborative_md_assignments';

    /**
     * @var array
     */
    protected $dates = [
        'association_start',
        'association_end'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function collaborativeMd()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\User', 'id', 'md_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nurse()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\User', 'id', 'nurse_user_id');
    }
}